<?php
// share.php - Botões de compartilhamento para redes sociais
// Use: include 'share.php';

// Pega a URL atual da página
$url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

?>
<div class="share-buttons" style="display:flex;gap:10px;">
  <a href="https://wa.me/?text=<?php echo urlencode($url); ?>" target="_blank" title="Compartilhar no WhatsApp">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/whatsapp.svg" alt="WhatsApp" style="width:32px;height:32px;">
  </a>
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank" title="Compartilhar no Facebook">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/facebook.svg" alt="Facebook" style="width:32px;height:32px;">
  </a>
  <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($url); ?>" target="_blank" title="Compartilhar no Twitter">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/twitter.svg" alt="Twitter" style="width:32px;height:32px;">
  </a>
  <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode($url); ?>" target="_blank" title="Compartilhar no LinkedIn">
    <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/linkedin.svg" alt="LinkedIn" style="width:32px;height:32px;">
  </a>
</div>
