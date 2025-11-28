function setupPostCarousel() {
    const carousel = document.getElementById('postCarousel');
    if (!carousel) return;

    const inner = carousel.querySelector('.carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');
    const indicators = carousel.querySelectorAll('.indicator');
    
    if (items.length <= 1) return;

    let currentIndex = 0;
    let isTransitioning = false;

    function showSlide(index) {
        if (isTransitioning || index < 0 || index >= items.length) return;
        
        isTransitioning = true;
        inner.style.transform = `translateX(-${index * 100}%)`;
        
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
        
        currentIndex = index;
        
        setTimeout(() => {
            isTransitioning = false;
        }, 500);
    }

    function moveSlide(direction) {
        let newIndex = currentIndex + direction;
        
        if (newIndex < 0) {
            newIndex = items.length - 1;
        } else if (newIndex >= items.length) {
            newIndex = 0;
        }
        
        showSlide(newIndex);
    }

    function goToSlide(index) {
        if (index >= 0 && index < items.length) {
            showSlide(index);
        }
    }

    carousel.querySelector('.prev').addEventListener('click', () => moveSlide(-1));
    carousel.querySelector('.next').addEventListener('click', () => moveSlide(1));

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
    });

    showSlide(0);
}

    const setupPublicacaoModal = () => {
        const btnAdicionar = document.querySelector('.btn-adicionar');
        const modalPublicacao = document.getElementById('modalPublicacao');
        
        if (!btnAdicionar || !modalPublicacao) return;

        const closeModal = () => {
            modalPublicacao.classList.remove('active');
            document.body.style.overflow = '';
        };

        const openModal = () => {
            const dataAtual = new Date();
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            document.getElementById('dataAtual').textContent = dataAtual.toLocaleDateString('pt-BR', options);
            
            modalPublicacao.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        btnAdicionar.addEventListener('click', openModal);

        document.querySelectorAll('.modal-publicacao-close, .modal-publicacao-cancel').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalPublicacao.addEventListener('click', (e) => {
            if (e.target === modalPublicacao) closeModal();
        });

        document.getElementById('formPublicacao')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const titulo = document.getElementById('tituloPublicacao').value.trim();
            if (!titulo) { alert('Informe um título.'); return; }
            const fd = new FormData(form);
            try {
                const resp = await fetch('../api/publicacoes_criar.php', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                const data = await resp.json();
                if (!resp.ok || !data.ok) throw new Error(data.error || 'Falha ao criar publicação');
                form.reset();
                closeModal();
                window.location.href = data.redirect;
            } catch (err) {
                console.error(err);
                alert('Erro ao criar publicação.');
            }
        });

        document.getElementById('imagemPublicacao')?.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.files.length > 0) {
                label.textContent = this.files[0].name;
            } else {
                label.innerHTML = '<i class="ti-image mr-2"></i>Selecione uma imagem';
            }
        });
    };

    

    const setupExclusaoPublicacaoModal = () => {
        const deleteButton = document.querySelector('.btn-excluir');
        const modalExcluirOverlay = document.getElementById('modalExcluirPublicacao');
        
        if (!deleteButton || !modalExcluirOverlay) {
            console.error('Elementos do modal de exclusão de publicações não encontrados!');
            return;
        }

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            document.querySelectorAll('.publi-checkbox:checked').forEach(checkbox => {
                checkbox.checked = false;
            });
        };

        const openModal = () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecione pelo menos uma publicação para excluir.');
                return;
            }
            document.body.classList.add('modal-open');
            modalExcluirOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        deleteButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });

        document.getElementById('cancelarExclusaoPubli')?.addEventListener('click', closeModal);

        modalExcluirOverlay.addEventListener('click', (e) => {
            if (e.target === modalExcluirOverlay) closeModal();
        });

        document.getElementById('confirmarExclusaoPubli')?.addEventListener('click', async () => {
            const ids = Array.from(document.querySelectorAll('.publi-checkbox:checked'))
                .map(cb => parseInt(cb.value, 10))
                .filter(Number.isFinite);
            if (!ids.length) { closeModal(); return; }
            if (!confirm('Confirmar exclusão das publicações selecionadas?')) return;
            try {
                const resp = await fetch('../api/publicacoes_excluir.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids })
                });
                const data = await resp.json().catch(() => ({}));
                if (!resp.ok || !data.ok) throw new Error(data.error || 'Falha ao excluir');
                closeModal();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Erro ao excluir publicações.');
            }
        });

    }; // fim setupExclusaoPublicacaoModal

    const setupAgendaAdmin = () => {
    try {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next',      // navegação
                center: 'title',        // título (mês/ano) no meio
                right: 'month,agendaWeek,agendaDay' // botões de visualização à direita
            },
            defaultView: 'month',
            defaultDate : moment().format('YYYY-MM-DD'), 
            locale: 'pt-br',
            editable: false, 
            selectable: true,
            eventLimit: true,
            height: 'auto',
            contentHeight: 'auto',
            events: '../api/atividades_listar.php',
            selectHelper: true,
            select: function(start, end, jsEvent, view) {
                // Prefill com intervalo selecionado; em visualização mensal o "end" é exclusivo
                var selStart = start && start.clone ? start.clone() : moment(start);
                var selEnd = end && end.clone ? end.clone() : (end ? moment(end) : null);
                // Ajusta horas para o horário atual para facilitar edição
                var now = moment();
                selStart.hour(now.hour()).minute(now.minute()).second(0);
                if (selEnd) {
                    // Em month view, end é exclusivo; reduz 1 minuto para exibir fim inclusivo
                    if (view && view.name === 'month') selEnd.subtract(1, 'minute');
                    selEnd.hour(now.hour()).minute(now.minute()).second(0);
                }
                abrirModalEventoAdmin({ start: selStart, end: selEnd ? selEnd : null });
            },
            dayClick: function(date, jsEvent, view) {
                // Clique simples em um dia: usa data clicada com hora atual e +1h de duração
                var start = date && date.clone ? date.clone() : moment(date);
                var now = moment();
                start.hour(now.hour()).minute(now.minute()).second(0);
                var end = start.clone().add(1, 'hour');
                abrirModalEventoAdmin({ start: start, end: end });
            },
            eventClick: function(event) {
                // Ao clicar em uma atividade registrada, abre o modal de presenças (não o de edição)
                abrirModalListaPresencas(event);
            },
            eventDrop: function(event, delta, revertFunc) {
                if(!confirm("Tem certeza que deseja alterar a data deste evento?")) {
                    revertFunc(); 
                }
            }
        });

        const modalEvento = document.getElementById('modalEvento');
        const modalTitulo = document.getElementById('modalEventoTitulo');
        const formEvento = document.getElementById('formEvento');
        const tituloInput = document.getElementById('tituloEvento');
        const dataInicioInput = document.getElementById('dataInicio');
        const dataFimInput = document.getElementById('dataFim');
        const corSelect = document.getElementById('corEvento');
        const btnCancelar = document.querySelector('.btn-cancelar');
        const btnFechar = document.querySelector('.modal-evento-close');
        const btnAdicionarEvento = document.getElementById('adicionarEvento');

        function abrirModalEventoAdmin(evento) {
            modalTitulo.textContent = evento.title ? 'Editar Evento' : 'Novo Evento';
            tituloInput.value = evento.title || '';
            dataInicioInput.value = moment(evento.start).format('YYYY-MM-DDTHH:mm');
            dataFimInput.value = evento.end ? moment(evento.end).format('YYYY-MM-DDTHH:mm') : '';
            corSelect.value = (Array.isArray(evento.className) ? evento.className[0] : evento.className) || '';
            
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            formEvento.dataset.eventoId = evento.id || '';

            // Na criação, não exibimos nada de presenças aqui; clique em evento abre outro modal
            const presencaWrapper = document.getElementById('presencaAdminWrapper');
            if (presencaWrapper) presencaWrapper.style.display = 'none';
        }

        const apiBaseAdmin = (function(){
            const p = window.location.pathname;
            if (p.includes('/admin/')) return '../api';
            if (p.includes('/membro/')) return '../api';
            return './api';
        })();

        // Abre diretamente o modal de lista de presenças com dados agrupados
        async function abrirModalListaPresencas(evento) {
            const modal = document.getElementById('modalListaPresencas');
            const lista = document.getElementById('listaPresencas');
            const titulo = document.getElementById('tituloListaPresencas');
            if (!modal || !lista) return;
            if (titulo) {
                const dt = moment(evento.start).format('DD/MM/YYYY');
                const hrIni = moment(evento.start).format('HH:mm');
                const hrFim = evento.end ? moment(evento.end).format('HH:mm') : '';
                const hrTxt = (evento.start && evento.start.hasTime && evento.start.hasTime()) ? (hrFim ? `${hrIni} - ${hrFim}` : hrIni) : 'Dia todo';
                titulo.textContent = `Presenças: ${evento.title} — ${dt} ${hrTxt ? '• ' + hrTxt : ''}`;
            }

            const close = () => { modal.classList.remove('active'); document.body.style.overflow = ''; };
            const btnFechar = document.getElementById('btnFecharPresencas');
            const btnX = document.getElementById('fecharModalPresencas');
            btnFechar?.addEventListener('click', close, { once: true });
            btnX?.addEventListener('click', close, { once: true });
            modal.addEventListener('click', (e) => { if (e.target === modal) close(); }, { once: true });

            lista.innerHTML = '<p class="small-text">Carregando...</p>';
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            try {
                const resp = await fetch(apiBaseAdmin + '/presenca_listar.php?atividade_id=' + encodeURIComponent(evento.id));
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao listar');

                const membros = Array.isArray(data.membros) ? data.membros : [];
                const presentes = membros.filter(m => m.status === 'presente');
                const ausentes = membros.filter(m => m.status === 'ausente');
                const naoInf  = membros.filter(m => m.status === 'nao_informado');

                const makeSection = (tituloSec, arr, color) => {
                    const badge = `<span class="small-text" style="color:${color}">${arr.length}</span>`;
                    const items = arr.map(m => `
                        <div class="membro-item" style="display:flex; justify-content:space-between; align-items:center; gap:10px; padding:6px 0; border-bottom:1px solid #eee;">
                          <div style="min-width:0;">
                            <div style="font-weight:600;">${m.nome}</div>
                            <div class="small-text" style="color:#777; word-break:break-word;">${m.email}</div>
                          </div>
                          <div class="small-text" style="white-space:nowrap; color:${color}">${tituloSec}</div>
                        </div>
                    `).join('');
                    return `
                      <div style="margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin:6px 0 8px;">
                          <h4 style="margin:0; font-size:16px;">${tituloSec}</h4>
                          ${badge}
                        </div>
                        <div>${items || '<div class="small-text" style="color:#777;">Nenhum</div>'}</div>
                      </div>
                    `;
                };

                lista.innerHTML = [
                    makeSection('Confirmado', presentes, '#28a745'),
                    makeSection('Não vai', ausentes, '#dc3545'),
                    makeSection('Não informaram', naoInf, '#6c757d')
                ].join('');
            } catch (err) {
                console.error(err);
                lista.innerHTML = '<p class="small-text">Erro ao carregar a lista de presenças.</p>';
            }
        }

        function fecharModalEventoAdmin() {
            modalEvento.classList.remove('active');
            document.body.style.overflow = '';
        }

        btnCancelar.addEventListener('click', fecharModalEventoAdmin);
        btnFechar.addEventListener('click', fecharModalEventoAdmin);
        modalEvento.addEventListener('click', (e) => {
            if (e.target === modalEvento) fecharModalEventoAdmin();
        });

        formEvento.addEventListener('submit', async function(e) {
            e.preventDefault();
            const descricao = tituloInput.value.trim();
            const data_hora = dataInicioInput.value;
            const data_fim = dataFimInput.value || null;
            const cor = corSelect.value || null;
            if (!descricao || !data_hora) {
                alert('Informe título e data/hora');
                return;
            }
            try {
                const resp = await fetch('../api/atividades_criar.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ descricao, data_hora, data_fim, cor })
                });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao criar atividade');
                $('#calendar').fullCalendar('refetchEvents');
                fecharModalEventoAdmin();
            } catch (err) {
                console.error(err);
                alert('Erro ao salvar atividade.');
            }
        });

        if (btnAdicionarEvento) {
            btnAdicionarEvento.addEventListener('click', () => {
                abrirModalEventoAdmin({
                    start: new Date(),
                    end: moment().add(1, 'hour').toDate()
                });
            });
        }

    // Excluir atividades (modal com lista)
        const btnExcluirAtividade = document.getElementById('excluirAtividade');
        const modalExcluir = document.getElementById('modalExcluirAtividade');
        const listaAtividades = document.getElementById('listaAtividades');
        const fecharExcluir = () => { modalExcluir.classList.remove('active'); document.body.style.overflow = ''; };
        const abrirExcluir = () => { modalExcluir.classList.add('active'); document.body.style.overflow = 'hidden'; };
        document.querySelector('#modalExcluirAtividade .modal-close')?.addEventListener('click', fecharExcluir);
        document.getElementById('cancelarExclusaoAtividade')?.addEventListener('click', fecharExcluir);
        modalExcluir?.addEventListener('click', (e) => { if (e.target === modalExcluir) fecharExcluir(); });
        
        async function carregarListaAtividades() {
            listaAtividades.innerHTML = '<p class="small-text">Carregando...</p>';
            try {
                const resp = await fetch('../api/atividades_listar.php');
                const eventos = await resp.json();
                if (!Array.isArray(eventos) || eventos.length === 0) {
                    listaAtividades.innerHTML = '<p class="small-text">Nenhuma atividade encontrada.</p>';
                    return;
                }
                const html = eventos.map(ev => {
                    const dt = moment(ev.start).format('DD/MM/YYYY HH:mm');
                    return `<label class="membro-item"><input type="checkbox" class="chk-atividade" value="${ev.id}"> <span><strong>${dt}</strong> — ${ev.title}</span></label>`;
                }).join('');
                listaAtividades.innerHTML = `<div class="membros-list">${html}</div>`;
            } catch (err) {
                console.error(err);
                listaAtividades.innerHTML = '<p class="small-text">Erro ao carregar atividades.</p>';
            }
        }

        btnExcluirAtividade?.addEventListener('click', (e) => {
            e.preventDefault();
            carregarListaAtividades();
            abrirExcluir();
        });

        document.getElementById('confirmarExclusaoAtividade')?.addEventListener('click', async () => {
            const ids = Array.from(document.querySelectorAll('.chk-atividade:checked')).map(i => parseInt(i.value));
            if (ids.length === 0) { alert('Selecione ao menos uma atividade.'); return; }
            if (!confirm('Excluir as atividades selecionadas?')) return;
            try {
                const resp = await fetch('../api/atividades_excluir.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids })
                });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao excluir');
                $('#calendar').fullCalendar('refetchEvents');
                fecharExcluir();
            } catch (err) {
                console.error(err);
                alert('Erro ao excluir atividades.');
            }
        });

        // Removido o botão dentro do modal de edição: clique direto no evento usa abrirModalListaPresencas

    } catch (error) {
        console.error('Erro ao inicializar calendário admin:', error);
        $('#calendar').php('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
    }
};

function setupModalNovaDiscussaoMembro() {
    const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
    const modal = document.getElementById('modalNovaDiscussaoMembro');
    
    if (!btnNovaDiscussao || !modal) {
        console.error('Elementos do modal de membros não encontrados!');
        return;
    }
    
    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };
    
    const openModal = () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    
    btnNovaDiscussao.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });
    
    modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-button')?.addEventListener('click', closeModal);
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    
    const form = document.getElementById('formNovaDiscussaoMembro');
    if (form) {
        form.addEventListener('submit', function(e) {
            const selecionados = form.querySelectorAll('.checkbox-participante-membro:checked').length;
            if (selecionados === 0) {
                e.preventDefault();
                alert('Selecione ao menos um participante.');
            }
        });
    }
}

function setupModalNovaDiscussaoAdmin() {
    const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
    const modal = document.getElementById('modalNovaDiscussao');

    if (!btnNovaDiscussao || !modal) return;

    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    const openModal = () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    btnNovaDiscussao.addEventListener('click', (e) => {
        e.preventDefault();
        openModal();
    });

    modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-button')?.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    const form = document.getElementById('formNovaDiscussao');
    if (form) {
        form.addEventListener('submit', (e) => {
            const selecionados = form.querySelectorAll('.checkbox-participante-admin:checked').length;
            if (selecionados === 0) {
                e.preventDefault();
                alert('Selecione ao menos um participante.');
            }
        });
    }
}

function setupSelectAllParticipants() {
    document.querySelectorAll('[data-select-all-target]').forEach(master => {
        const targetSelector = master.getAttribute('data-select-all-target');
        if (!targetSelector) return;

        const syncState = () => {
            const targets = document.querySelectorAll(targetSelector);
            if (!targets.length) {
                master.checked = false;
                master.indeterminate = false;
                return;
            }
            const checked = Array.from(targets).filter(cb => cb.checked).length;
            master.checked = checked === targets.length;
            master.indeterminate = checked > 0 && checked < targets.length;
        };

        master.addEventListener('change', () => {
            const targets = document.querySelectorAll(targetSelector);
            targets.forEach(cb => {
                cb.checked = master.checked;
            });
            master.indeterminate = false;
        });

        document.querySelectorAll(targetSelector).forEach(cb => {
            cb.addEventListener('change', syncState);
        });

        syncState();
    });
}

function setupMenuLateralToggle() {
    const botaoMenu = document.getElementById('botao-menu');
    const menuLateral = document.getElementById('menuLateral');
    if (!botaoMenu || !menuLateral) return;

    botaoMenu.addEventListener('click', (e) => {
        e.preventDefault();
        menuLateral.classList.toggle('ativo');
        const aberto = menuLateral.classList.contains('ativo');
        // Alterna classe visual do botão para trocar hambúrguer/X via CSS
        botaoMenu.classList.toggle('ativo', aberto);
    });
}

function setupExcluirDiscussoesModal() {
    const deleteButton = document.querySelector('.btn-excluir-discussao');
    const modalExcluir = document.getElementById('modalExcluirDiscussao');
    const listaDiscussoes = document.getElementById('listaDiscussoesAdmin');
    if (!deleteButton || !modalExcluir || !listaDiscussoes) return;

    const closeModal = () => {
        modalExcluir.classList.remove('active');
        document.body.style.overflow = '';
    };

    const openModal = () => {
        modalExcluir.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const renderLista = (discussoes) => {
        if (!Array.isArray(discussoes) || discussoes.length === 0) {
            listaDiscussoes.innerHTML = '<p class="small-text">Nenhum chat disponível.</p>';
            return;
        }
        const html = discussoes.map(disc => {
            const data = disc.data_criacao ? new Date(disc.data_criacao).toLocaleDateString('pt-BR') : '';
            return `<label class="membro-item"><input type="checkbox" class="checkbox-discussao" value="${disc.id_discussao}"> <span><strong>${disc.titulo_discussao}</strong>${data ? ` — ${data}` : ''}</span></label>`;
        }).join('');
        listaDiscussoes.innerHTML = `<div class="membros-list">${html}</div>`;
    };

    const carregarDiscussoes = async () => {
        listaDiscussoes.innerHTML = '<p class="small-text">Carregando discussões...</p>';
        try {
            const resp = await fetch('../api/discussoes_listar.php');
            const data = await resp.json().catch(() => []);
            if (!resp.ok) throw new Error((data && data.error) || 'Falha ao carregar');
            const lista = Array.isArray(data) ? data : data?.discussoes;
            renderLista(lista || []);
        } catch (err) {
            console.error(err);
            listaDiscussoes.innerHTML = '<p class="small-text">Erro ao carregar discussões.</p>';
        }
    };

    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();
        carregarDiscussoes().finally(openModal);
    });

    modalExcluir.querySelector('.modal-close')?.addEventListener('click', closeModal);
    document.getElementById('cancelarExclusaoDiscussao')?.addEventListener('click', closeModal);
    modalExcluir.addEventListener('click', (e) => {
        if (e.target === modalExcluir) closeModal();
    });

    document.getElementById('confirmarExclusaoDiscussao')?.addEventListener('click', async () => {
        const ids = Array.from(document.querySelectorAll('.checkbox-discussao:checked')).map(cb => parseInt(cb.value, 10)).filter(Boolean);
        if (!ids.length) {
            alert('Selecione ao menos um chat.');
            return;
        }
        if (!confirm('Confirma a exclusão das discussões selecionadas?')) return;
        try {
            const resp = await fetch('../api/discussoes_excluir.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids })
            });
            const data = await resp.json().catch(() => ({}));
            if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Não foi possível excluir');
            closeModal();
            window.location.reload();
        } catch (err) {
            console.error(err);
            alert('Erro ao excluir chats.');
        }
    });
}
// ==== Função de Agenda para Membro (faltava e causava erro) ====
function setupAgendaMembro(){
    try {
        const calendarEl = document.getElementById('calendar');
        if(!calendarEl) return;
        // Prefixo de API diferente para páginas de membro
        const apiPrefix = '../api/';
        $('#calendar').fullCalendar({
            locale: 'pt-br',
            height: 'auto',
            timezone: 'local',
            header: { left: 'prev,next today', center: 'title', right: 'month,agendaWeek,agendaDay' },
            events: apiPrefix + 'atividades_listar.php',
            eventClick: function(calEvent){
                const modal = document.getElementById('modalEvento');
                if(!modal) return;
                modal.classList.add('active');
                document.body.classList.add('modal-open');
                document.body.style.overflow = 'hidden';
                const tituloSpan = document.getElementById('evento-titulo');
                const dataSpan = document.getElementById('evento-data');
                const horarioSpan = document.getElementById('evento-horario');
                if(tituloSpan) tituloSpan.textContent = calEvent.title || 'Evento';
                if(dataSpan) dataSpan.textContent = moment(calEvent.start).format('DD/MM/YYYY');
                if(horarioSpan) horarioSpan.textContent = moment(calEvent.start).format('HH:mm');
                const atividadeId = calEvent.id;
                // Carrega status de presença
                fetch(apiPrefix + 'presenca_obter.php?atividade_id=' + atividadeId)
                    .then(r => r.ok ? r.json() : null)
                    .then(data => {
                        if(data && data.ok){
                            const st = document.getElementById('status-text');
                            if(st) st.textContent = data.status === 'presente' ? 'Presente' : (data.status === 'ausente' ? 'Ausente' : 'Não informado');
                        }
                    }).catch(()=>{});
                // Ações de presença
                const btnPresente = document.getElementById('btn-presente');
                const btnAusente = document.getElementById('btn-ausente');
                const registrar = (status) => {
                    fetch(apiPrefix + 'presenca_registrar.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({atividade_id: atividadeId, status})})
                        .then(r => r.json())
                        .then(data => {
                            if(data && data.ok){
                                const st = document.getElementById('status-text');
                                if(st) st.textContent = status === 'presente' ? 'Presente' : 'Ausente';
                            } else { alert('Falha ao registrar presença.'); }
                        })
                        .catch(()=> alert('Erro ao registrar presença.'));
                };
                btnPresente && (btnPresente.onclick = () => registrar('presente'));
                btnAusente && (btnAusente.onclick = () => registrar('ausente'));
                // Fechar modal
                modal.querySelector('.modal-evento-close')?.addEventListener('click', closeModal);
                function closeModal(){
                    modal.classList.remove('active');
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                }
                modal.addEventListener('click', (e)=>{ if(e.target === modal) closeModal(); });
            }
        });
    } catch(err){ console.error('Erro agenda membro', err); }
}

// ===== Stubs seguros (evitam ReferenceError sem alterar funcionalidades existentes) =====
if(typeof setupCadastroModal === 'undefined') window.setupCadastroModal = function(){};
if(typeof setupExclusaoModal === 'undefined') window.setupExclusaoModal = function(){
    const btn = document.querySelector('.delete-member-button');
    const overlay = document.getElementById('modalExcluirMembro');
    if(!btn || !overlay) return;
    const cancelar = document.getElementById('cancelarExclusao');
    const confirmar = document.getElementById('confirmarExclusao');
    btn.addEventListener('click', (e)=>{ e.preventDefault(); overlay.classList.add('active'); document.body.style.overflow='hidden'; });
    function fechar(){ overlay.classList.remove('active'); document.body.style.overflow=''; }
    cancelar?.addEventListener('click', fechar);
    overlay.addEventListener('click', e=>{ if(e.target === overlay) fechar(); });
    confirmar?.addEventListener('click', async ()=>{
        const ids = Array.from(document.querySelectorAll('.member-checkbox:checked')).map(cb=>parseInt(cb.value,10)).filter(Boolean);
        if(!ids.length){ fechar(); return; }
        try {
            const resp = await fetch('../api/membros_excluir.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({ids})});
            const data = await resp.json();
            if(!resp.ok || !data.ok) alert(data.error || 'Falha ao excluir');
            fechar();
            window.location.reload();
        } catch { alert('Erro na exclusão'); }
    });
};
if(typeof setupSupportModal === 'undefined') window.setupSupportModal = function(){};
if(typeof setupUploadModal === 'undefined') window.setupUploadModal = function(){
    const btn = document.getElementById('openUploadModal');
    const overlay = document.getElementById('modalUpload');
    if(!btn || !overlay) return;
    const closeButtons = overlay.querySelectorAll('.close-modal, .cancel-button');
    const form = document.getElementById('uploadForm');
    const tipoRadios = overlay.querySelectorAll('input[name="tipo"]');
    const grupoArquivo = overlay.querySelector('.group-arquivo');
    const grupoLink = overlay.querySelector('.group-link');
    btn.addEventListener('click', ()=>{ overlay.classList.add('active'); document.body.style.overflow='hidden'; });
    function fechar(){ overlay.classList.remove('active'); document.body.style.overflow=''; }
    closeButtons.forEach(b=> b.addEventListener('click', fechar));
    overlay.addEventListener('click', e=>{ if(e.target === overlay) fechar(); });
    tipoRadios.forEach(r=> r.addEventListener('change', ()=>{
        const val = document.querySelector('input[name="tipo"]:checked')?.value || 'arquivo';
        if(val === 'link'){ grupoArquivo.style.display='none'; grupoLink.style.display='block'; } else { grupoArquivo.style.display='block'; grupoLink.style.display='none'; }
    }));
    form?.addEventListener('submit', async e=>{
        e.preventDefault();
        const fd = new FormData(form);
        try {
            const resp = await fetch('../api/arquivos_upload.php',{method:'POST', body: fd});
            const data = await resp.json();
            if(!resp.ok || !data.ok){ alert(data.error || 'Falha no upload'); return; }
            fechar();
            window.location.reload();
        } catch { alert('Erro no upload'); }
    });
};
if(typeof setupBiografiaEdicao === 'undefined') window.setupBiografiaEdicao = function(){};
if(typeof setupPerfilModals === 'undefined') window.setupPerfilModals = function(){};

// ==== Chat integrado (anteriormente em chat/chat.js) ====
(function(){
    'use strict';
    function ready(fn){ if(document.readyState!=='loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
    ready(initChat);


// ===== Add Membro: atualização do nome do arquivo selecionado =====
function setupAddMembroFotoInput(){
    const input = document.getElementById('fotoMembro');
    const fileName = document.getElementById('fileName');
    if(!input || !fileName) return;
    input.addEventListener('change', function(){
        if (this.files && this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            fileName.style.color = 'var(--verde)';
            fileName.style.fontWeight = '500';
        } else {
            fileName.textContent = 'Nenhum arquivo selecionado';
            fileName.style.color = '#666';
            fileName.style.fontWeight = 'normal';
        }
    });
}

// Inicializa comportamento da página Add Membro quando presente
setupAddMembroFotoInput();
    function initChat(){
        const container = document.querySelector('.chat-messages');
        const input = document.querySelector('.chat-input textarea');
        const sendBtn = document.querySelector('.btn-enviar');
        const emojiBtn = document.querySelector('.btn-emoji');
        const replyBox = document.querySelector('.reply-container');
        const replyText = replyBox?.querySelector('.reply-text');
        const cancelReply = replyBox?.querySelector('.cancel-reply');
        if(!container || !input || !sendBtn) return; // não está na página de chat

        const params = new URLSearchParams(window.location.search);
        const chatId = parseInt(params.get('id')||'0',10);
        if(!chatId) return;

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
            const inputContainer = document.querySelector('.chat-input-container') || container.parentElement;
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

        function esc(str){
            return (str||'').replace(/[&<>"']/g,function(ch){
                return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[ch];
            });
        }

        function formatTime(ts){
            if(!ts) return '';
            try {
                const base = new Date(ts.replace(' ','T'));
                const adjusted = new Date(base.getTime() - 3*60*60*1000); // ajuste -3h
                return new Intl.DateTimeFormat('pt-BR',{ timeZone:'America/Sao_Paulo', day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'}).format(adjusted);
            } catch { return ts; }
        }

        function buildMessage(m){
            const mine = (m.user_id && m.user_id === currentUserId);
            const bubbleSide = mine ? ' mine' : ' other';
            const deletedClass = m.is_deleted ? ' message-deleted' : '';
            const body = m.message === null ? '<span class="removed">Mensagem removida</span>' : esc(m.message);
            const parent = (m.parent && m.parent.message !== null) ? `<div class="message-parent">↪ <strong>${esc(m.parent.user_name)}:</strong> ${esc(m.parent.message)}</div>` : '';
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

        fetchMessages();
        pollHandle = setInterval(fetchMessages, 3000);
    }
})();

const setupBiografiaPage = () => {
    const editButton = document.querySelector('.edit-button');
    const biographyText = document.querySelector('.biography-text');
    
    const changePhotoButton = document.querySelector('.change-photo-button');
    const profileImage = document.querySelector('.profile-image');
    
    if (editButton && biographyText) {
        editButton.addEventListener('click', async () => {
            const isEditing = biographyText.hasAttribute('contenteditable');
            if (isEditing) {
                // Salvar conteúdo editado
                const idInput = document.querySelector('#formEditarContato input[name="id_usuario"], #formEditarFoto input[name="id_usuario"]');
                const idUsuario = idInput?.value || '';
                const plainText = biographyText.innerText.trim();
                try {
                    const resp = await fetch('../include/atualizar_biografia.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_usuario=${encodeURIComponent(idUsuario)}&bio=${encodeURIComponent(plainText)}`
                    });
                    const data = await resp.json().catch(() => ({}));
                    if (!resp.ok || !data.ok) throw new Error(data.msg || 'Erro ao salvar biografia');
                    biographyText.removeAttribute('contenteditable');
                } catch (err) {
                    console.error(err);
                    alert(err.message || 'Erro ao salvar biografia');
                }
                return; // encerra após salvar
            }
            // Entrar em modo edição
            biographyText.setAttribute('contenteditable','true');
            biographyText.focus();
        });
    }
};

    const setupEsqueceuSenhaModal = () => {};

    function setupAdminButtons() {
        document.querySelectorAll('.delete-message-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const message = this.closest('.message');
                if (message) {
                    if (confirm('Simulação: Apagar esta mensagem?')) {
                        message.style.opacity = '0.5';
                        message.style.backgroundColor = '#ffecec';
                        alert('Simulação: Mensagem marcada para exclusão!');
                    }
                }
            });
        });
    }

const setupExclusaoArquivoModal = () => {
    const deleteButton = document.getElementById('openDeleteModal');
    const modalExcluirOverlay = document.getElementById('modalExcluirMembro');
    
    if (!deleteButton || !modalExcluirOverlay) return;

    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Por favor, selecione pelo menos um arquivo para excluir.');
            return;
        }
        
        document.body.classList.add('modal-open');
        modalExcluirOverlay.classList.add('active');
        document.body.style.overflow = ('hidden');
    });

    document.getElementById('cancelarExclusao')?.addEventListener('click', () => {
        document.body.classList.remove('modal-open');
        modalExcluirOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    document.getElementById('confirmarExclusao')?.addEventListener('click', async () => {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkboxes.length === 0) return;
        const ids = Array.from(checkboxes).map(cb => parseInt(cb.value, 10)).filter(Number.isFinite);
        try {
            const resp = await fetch('../api/arquivos_excluir.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids })
            });
            const data = await resp.json().catch(() => ({ ok: false, error: 'Falha ao interpretar resposta' }));
            if (!resp.ok || !data.ok) throw new Error(data.error || 'Erro ao excluir arquivos');
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            window.location.reload();
        } catch (err) {
            console.error(err);
            alert('Erro: ' + (err && err.message ? err.message : 'Não foi possível excluir.'));
        }
    });

    modalExcluirOverlay.addEventListener('click', (e) => {
        if (e.target === modalExcluirOverlay) {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
};

    const setupNovaAcaoModal = () => {
        const btnAdicionar = document.querySelector('.btn-adicionar');
        const modalAcao = document.getElementById('modalNovaAcao');
        
        if (!btnAdicionar || !modalAcao) return;

        const closeModal = () => {
            modalAcao.classList.remove('active');
            document.body.style.overflow = '';
        };

        const openModal = () => {
            const dataAtual = new Date();
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            document.getElementById('dataAtualAcao').textContent = dataAtual.toLocaleDateString('pt-BR', options);
            
            modalAcao.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        btnAdicionar.addEventListener('click', openModal);

        document.querySelectorAll('.modal-acao-close, .modal-acao-cancel').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalAcao.addEventListener('click', (e) => {
            if (e.target === modalAcao) closeModal();
        });

        document.getElementById('formAcao')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const titulo = document.getElementById('tituloAcao').value;
            const descricao = document.getElementById('descricaoAcao').value;
            const imagem = document.getElementById('imagemAcao').files[0];
            
            console.log('Nova ação:', { titulo, descricao, imagem });
            alert('Ação criada com sucesso!');
            
            e.target.reset();
            closeModal();
        });

        document.getElementById('imagemAcao')?.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.files.length > 0) {
                label.textContent = this.files[0].name;
            } else {
                label.innerHTML = '<i class="ti-image mr-2"></i>Selecione uma imagem';
            }
        });
    };

    const setupExclusaoAcaoModal = () => {
        const deleteButton = document.querySelector('.btn-excluir');
        const modalExcluirOverlay = document.getElementById('modalExcluirAcao');
        
        if (!deleteButton || !modalExcluirOverlay) {
            console.error('Elementos do modal de exclusão de ações não encontrados!');
            return;
        }

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            document.querySelectorAll('.publi-checkbox:checked').forEach(checkbox => {
                checkbox.checked = false;
            });
        };

        const openModal = () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecione pelo menos uma ação para excluir.');
                return;
            }
            document.body.classList.add('modal-open');
            modalExcluirOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        deleteButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });

        document.getElementById('cancelarExclusaoAcao')?.addEventListener('click', closeModal);

        modalExcluirOverlay.addEventListener('click', (e) => {
            if (e.target === modalExcluirOverlay) closeModal();
        });

        document.getElementById('confirmarExclusaoAcao')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            alert(`Simulação: ${checkboxes.length} ação(ões) marcada(s) para exclusão!`);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            closeModal();
        });
    };

    // === Eventos (CRUD real, usando tabela evento) ===
    const setupEventoModal = () => {
        const btnAdicionar = document.querySelector('.btn-adicionar');
        const modalEvento = document.getElementById('modalEvento');
        if (!btnAdicionar || !modalEvento) return;

        const closeModal = () => {
            modalEvento.classList.remove('active');
            document.body.style.overflow = '';
        };
        const openModal = () => {
            const span = document.getElementById('dataAtualEvento');
            if (span) {
                const now = new Date();
                span.textContent = now.toLocaleDateString('pt-BR') + ' ' + now.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            }
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        btnAdicionar.addEventListener('click', openModal);

        document.querySelectorAll('.modal-publicacao-close, .modal-publicacao-cancel').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });
        modalEvento.addEventListener('click', (e) => { if (e.target === modalEvento) closeModal(); });

        document.getElementById('formEvento')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const titulo = document.getElementById('tituloEvento')?.value?.trim();
            if (!titulo) { alert('Informe um título.'); return; }
            const fd = new FormData(form);
            try {
                const resp = await fetch('../api/eventos_criar.php', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao criar evento');
                form.reset();
                closeModal();
                window.location.href = data.redirect;
            } catch (err) {
                console.error(err);
                alert('Erro ao criar evento.');
            }
        });
    };

    const setupExclusaoEventoModal = () => {
        const deleteButton = document.querySelector('.btn-excluir');
        const modalExcluirOverlay = document.getElementById('modalExcluirEvento');
        if (!deleteButton || !modalExcluirOverlay) return;

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            document.querySelectorAll('.publi-checkbox:checked').forEach(cb => { cb.checked = false; });
        };
        const openModal = () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            if (checkboxes.length === 0) { alert('Selecione ao menos um evento para excluir.'); return; }
            document.body.classList.add('modal-open');
            modalExcluirOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        deleteButton.addEventListener('click', (e) => { e.preventDefault(); openModal(); });
        document.getElementById('cancelarExclusaoEvento')?.addEventListener('click', closeModal);
        modalExcluirOverlay.addEventListener('click', (e) => { if (e.target === modalExcluirOverlay) closeModal(); });
        document.getElementById('confirmarExclusaoEvento')?.addEventListener('click', async () => {
            const ids = Array.from(document.querySelectorAll('.publi-checkbox:checked')).map(cb => parseInt(cb.value, 10)).filter(Boolean);
            if (!ids.length) { closeModal(); return; }
            try {
                const resp = await fetch('../api/eventos_excluir.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ids }) });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao excluir evento');
                closeModal();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Erro ao excluir eventos.');
            }
        });
    };

    setupPostCarousel();

    if (document.getElementById('calendar')) {
        if (document.querySelector('.btn-adicionar')) {
            setupAgendaAdmin();
        } else {
            setupAgendaMembro();
        }
    }

    if (document.getElementById('modalNovaDiscussaoMembro')) {
        setupModalNovaDiscussaoMembro();
    }

    if (document.getElementById('modalNovaDiscussao')) {
        setupModalNovaDiscussaoAdmin();
    }

    setupSelectAllParticipants();

    if (document.querySelector('.btn-adicionar')) setupPublicacaoModal();
    if (document.querySelector('.add-member-button')) setupCadastroModal();
    if (document.querySelector('.delete-member-button')) setupExclusaoModal();
    if (document.querySelector('.btn-excluir')) setupExclusaoPublicacaoModal();
    if (document.getElementById('supportForm')) setupSupportModal();
    if (document.querySelector('.add-file-button')) setupUploadModal();
    if (document.querySelector('.forgot-password')) setupEsqueceuSenhaModal();
    // Executa edição de biografia apenas em páginas de biografia
    if (document.querySelector('.biography-container') && document.querySelector('.edit-text')) setupBiografiaEdicao();
    if (document.getElementById('openDeleteModal')) setupExclusaoArquivoModal();
    if (document.querySelector('.biography-container')) setupBiografiaPage();
    if (document.getElementById('modalFoto') || document.getElementById('modalContato')) setupPerfilModals();
    setupMenuLateralToggle();
    if (document.querySelector('.btn-excluir-discussao')) setupExcluirDiscussoesModal();

    if (window.location.pathname.includes('eventos-admin.php')) {
        setupEventoModal();
        setupExclusaoEventoModal();
    }

    // Edição da página Sobre (admin)
    function setupEditarSobre() {
        const editBtn = document.querySelector('.edit-text');
        const container = document.getElementById('sobreTexto');
        const buttons = document.getElementById('sobreEditButtons');
        if (!editBtn || !container || !buttons) return;

        let originalHTML = '';

        const startEdit = () => {
            originalHTML = container.innerHTML;
            container.setAttribute('contenteditable', 'true');
            container.classList.add('editing');
            buttons.style.display = 'flex';
            editBtn.setAttribute('disabled', 'disabled');
            editBtn.classList.remove('btn-primary');
            editBtn.classList.add('btn-secondary');
            editBtn.textContent = 'Modificando texto';
        };

        const cancelEdit = () => {
            container.innerHTML = originalHTML;
            container.removeAttribute('contenteditable');
            container.classList.remove('editing');
            buttons.style.display = 'none';
            editBtn.removeAttribute('disabled');
            editBtn.classList.remove('btn-secondary');
            editBtn.classList.add('btn-primary');
            editBtn.innerHTML = '<i class="ti-pencil mr-2"></i>Modificar Texto';
        };

        const saveEdit = async () => {
            // remove atributos contenteditable e quaisquer elementos de edição acidentais
            const tmp = document.createElement('div');
            tmp.innerHTML = container.innerHTML;
            tmp.querySelectorAll('[contenteditable]')?.forEach(el => el.removeAttribute('contenteditable'));
            tmp.querySelectorAll('.edit-buttons')?.forEach(el => el.remove());
            const html = tmp.innerHTML;
            try {
                const resp = await fetch('../include/atualizar_sobre.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: 'html=' + encodeURIComponent(html)
                });
                const data = await resp.json().catch(() => ({}));
                if (!resp.ok || !data.success) throw new Error(data.error || 'Falha ao salvar');
                container.removeAttribute('contenteditable');
                container.classList.remove('editing');
                buttons.style.display = 'none';
                editBtn.removeAttribute('disabled');
                editBtn.classList.remove('btn-secondary');
                editBtn.classList.add('btn-primary');
                editBtn.innerHTML = '<i class="ti-pencil mr-2"></i>Modificar Texto';
            } catch (err) {
                alert(err.message || 'Erro ao salvar');
            }
        };

        editBtn.addEventListener('click', (e) => { e.preventDefault(); startEdit(); });
        buttons.querySelector('.btn-cancelar')?.addEventListener('click', (e) => { e.preventDefault(); cancelEdit(); });
        buttons.querySelector('.btn-salvar')?.addEventListener('click', (e) => { e.preventDefault(); saveEdit(); });
    }

    if (window.location.pathname.includes('sobre-admin.php')) {
        setupEditarSobre();
    }

    setupAdminButtons();

    // Toggle de visualização de senha no login
    function setupPasswordToggle(){
        const toggle = document.querySelector('.toggle-password');
        const input = document.getElementById('password');
        if(!toggle || !input) return;
        toggle.addEventListener('click', function(){
            const mostrando = input.type === 'text';
            input.type = mostrando ? 'password' : 'text';
            this.setAttribute('aria-label', mostrando ? 'Mostrar senha' : 'Ocultar senha');
        });
    }
    if(document.querySelector('.toggle-password')) setupPasswordToggle();

    document.addEventListener("DOMContentLoaded", setupPostCarousel);


/* Profile dropdown toggle and logout (kept in central script file) */
(function() {
    function initProfileDropdown() {
        // One delegated click handler to manage open/close and clicks
        document.addEventListener('click', function(e) {
            // Prefer explicit simple selectors so closest() works reliably
            const clickedWrapper = e.target.closest('.profile-dropdown-wrapper');
            const clickedToggle = e.target.closest('.dropdown-toggle');
            const clickedMenu = e.target.closest('.profile-dropdown-menu');

            // If user clicked a toggle that's inside a profile wrapper -> toggle that menu
            if (clickedToggle && clickedWrapper && clickedWrapper.contains(clickedToggle)) {
                const menu = clickedWrapper.querySelector('.profile-dropdown-menu');
                if (!menu) return;
                // close other open menus first
                document.querySelectorAll('.profile-dropdown-menu.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });
                menu.classList.toggle('show');
                e.preventDefault();
                return;
            }

            // If clicked inside an open menu, allow link clicks to proceed
            if (clickedMenu) return;

            // Click outside dropdowns -> close any open menus
            document.querySelectorAll('.profile-dropdown-menu.show').forEach(m => m.classList.remove('show'));
        });

        // Delegated logout handler (works even if element is rendered later)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('#logout-btn');
            if (!btn) return;
            e.preventDefault();
            if (confirm('Deseja realmente sair da sua conta?')) {
                // server-side logout that destroys session and redirects
                window.location.href = '../anonimo/logout.php';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProfileDropdown);
    } else {
        initProfileDropdown();
    }
})();