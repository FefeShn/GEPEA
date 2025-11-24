// Chat frontend isolado (polling simples)
(function(){
  'use strict';
  function ready(fn){ if(document.readyState!=='loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
  ready(initChat);

  function initChat(){
    const container = document.querySelector('.chat-messages');
    const input = document.querySelector('.chat-input textarea');
    const sendBtn = document.querySelector('.btn-enviar');
    const emojiBtn = document.querySelector('.btn-emoji');
    const replyBox = document.querySelector('.reply-container');
    const replyText = replyBox?.querySelector('.reply-text');
    const cancelReply = replyBox?.querySelector('.cancel-reply');
    if(!container || !input || !sendBtn) return; // não está na página de chat

    // Descobre id do chat a partir da query string
    const params = new URLSearchParams(window.location.search);
    const chatId = parseInt(params.get('id')||'0',10);
    if(!chatId) return;

    // Admin detection (simples, path contém /admin/)
    const isAdmin = /\/admin\//.test(window.location.pathname);
    const currentUserId = window.CHAT_USER_ID || 0;
    let lastId = 0;
    let parentId = null;
    let pollHandle = null;

    // Emoji picker
    let emojiPicker = document.querySelector('.emoji-picker');
    if(!emojiPicker){
      emojiPicker = document.createElement('div');
      emojiPicker.className = 'emoji-picker';
      emojiPicker.style.display='none';
      const inputContainer = document.querySelector('.chat-input-container');
      inputContainer?.appendChild(emojiPicker);
    }
    const EMOJIS = ['😀','😊','😂','❤️','🔥','👍','🎉','🙏','😢','👏','🤔'];
    emojiPicker.innerHTML = EMOJIS.map(e => `<button type="button" class="emoji-item" data-emoji="${e}" aria-label="Emoji ${e}">${e}</button>`).join('');
    emojiPicker.addEventListener('click', e => {
      const btn = e.target.closest('.emoji-item');
      if(!btn) return;
      input.value += btn.getAttribute('data-emoji');
      input.focus();
    });

    emojiBtn?.addEventListener('click', () => {
      if(!emojiPicker) return;
      emojiPicker.style.display = (emojiPicker.style.display==='block') ? 'none' : 'block';
    });

    cancelReply?.addEventListener('click', () => hideReply());

    // Escape simples para HTML
    function esc(str){
      return (str||'').replace(/[&<>"']/g,function(ch){
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[ch];
      });
    }

    function formatTime(ts){
      if(!ts) return '';
      try {
        // Ajuste manual -3h (timestamp aparentemente vem adiantado 3h)
        const base = new Date(ts.replace(' ','T'));
        const adjusted = new Date(base.getTime() - 3*60*60*1000);
        return new Intl.DateTimeFormat('pt-BR',{ timeZone:'America/Sao_Paulo', day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'}).format(adjusted);
      } catch { return ts; }
    }

    function buildMessage(m){
      const mine = (m.user_id && m.user_id === currentUserId);
      const bubbleSide = mine ? ' mine' : ' other';
      const deletedClass = m.is_deleted ? ' message-deleted' : '';
      const body = m.message === null ? '<span class="removed">Mensagem removida</span>' : esc(m.message);
      const parent = (m.parent && m.parent.message !== null) ? `<div class="message-parent">↪ <strong>${esc(m.parent.user_name)}:</strong> ${esc(m.parent.message)}</div>` : '';
      // Ícones SVG inline (garante exibição mesmo sem fonte externa)
      const ICON_REPLY = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M5.921 11.9 1.253 8.72a.5.5 0 0 1 0-.82L5.92 4.719A.5.5 0 0 1 6.7 5.08v2.053c.5-.06 1.022-.099 1.554-.099 2.3 0 4.255.65 5.592 1.72.232.19.024.534-.246.46-1.648-.463-3.363-.673-5.346-.673-.527 0-1.043.037-1.554.098v2.054a.5.5 0 0 1-.78.36Z"/></svg>';
      const ICON_DELETE = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M5.5 5.5A.5.5 0 0 1 6 5h4a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5H6a.5.5 0 0 1-.5-.5v-8Z"/><path d="M9.5 1h-3l-.5 1H4a1 1 0 0 0-1 1v1h10V3a1 1 0 0 0-1-1h-2l-.5-1Z"/></svg>';
      const ICON_RESTORE = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1Z"/><path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466Z"/></svg>';
      const adminBtns = m.can_delete ? `<button class="msg-delete" data-id="${m.id}" title="Excluir" aria-label="Excluir mensagem">${ICON_DELETE}</button>${m.is_deleted?`<button class="msg-restore" data-id="${m.id}" title="Restaurar" aria-label="Restaurar mensagem">${ICON_RESTORE}</button>`:''}` : '';
      return `<div class="message-item${bubbleSide}${deletedClass}" data-id="${m.id}">
        ${parent}
        <div class="message-sender"><strong>${esc(m.user_name)}</strong></div>
        <div class="message-body">${body}</div>
        <div class="message-meta">
          <span class="message-time">${formatTime(m.created_at)}</span>
          <div class="message-actions"><button class="msg-reply" data-id="${m.id}" title="Responder" aria-label="Responder">${ICON_REPLY}</button>${adminBtns}</div>
        </div>
      </div>`;
    }

    function appendMessages(list){
      const frag = document.createDocumentFragment();
      list.forEach(m => {
        // assegura chave user_id para detecção local se não vier
        if(typeof m.user_id === 'undefined' && m.usuario_id) m.user_id = m.usuario_id;
        frag.appendChild(document.createRange().createContextualFragment(buildMessage(m)));
        lastId = Math.max(lastId,m.id);
      });
      container.appendChild(frag);
      container.scrollTop = container.scrollHeight;
    }

    async function fetchMessages(){
      try {
        const resp = await fetch(`../chat/fetch.php?chat_id=${chatId}&since_id=${lastId}`);
        if(!resp.ok) return;
        const data = await resp.json();
        if(Array.isArray(data.messages) && data.messages.length){ appendMessages(data.messages); }
      } catch(e){ /* silencioso */ }
    }

    async function sendMessage(){
      const text = input.value.trim();
      if(!text) return;
      const payload = { chat_id: chatId, message: text };
      if(parentId) payload.parent_id = parentId;
      try {
        const resp = await fetch('../chat/send.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
        const data = await resp.json();
        if(resp.ok && data.message){ appendMessages([data.message]); }
        input.value=''; parentId=null; hideReply();
      } catch(e){ alert('Falha ao enviar mensagem.'); }
    }

    async function deleteMessage(id, restore=false){
      try {
        const resp = await fetch('../chat/delete.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({message_id:id, restore: restore?1:0})});
        if(resp.ok){ fetchMessages(); }
      } catch(e){ alert('Erro ao processar exclusão.'); }
    }

    function showReply(el){
      parentId = parseInt(el.getAttribute('data-id'),10);
      if(replyBox){
        const body = el.querySelector('.message-body');
        replyText.textContent = body ? body.textContent.slice(0,120) : '';
        replyBox.style.display='block';
      }
    }
    function hideReply(){ if(replyBox){ replyBox.style.display='none'; replyText.textContent=''; } }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', e => { if(e.key==='Enter' && !e.shiftKey){ e.preventDefault(); sendMessage(); } });

    container.addEventListener('click', e => {
      const replyBtn = e.target.closest('.msg-reply');
      if(replyBtn){ showReply(replyBtn.closest('.message-item')); return; }
      const delBtn = e.target.closest('.msg-delete');
      if(delBtn && confirm('Excluir mensagem?')){ deleteMessage(parseInt(delBtn.dataset.id,10)); return; }
      const restoreBtn = e.target.closest('.msg-restore');
      if(restoreBtn && confirm('Restaurar mensagem?')){ deleteMessage(parseInt(restoreBtn.dataset.id,10), true); return; }
    });

    // Inicial
    fetchMessages();
    pollHandle = setInterval(fetchMessages, 3000);
  }
})();
