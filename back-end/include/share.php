<?php
$url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<div class="post-share">
  <span>Compartilhar:</span>
  <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
  <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($url); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
  <a href="https://www.instagram.com/?url=<?php echo urlencode($url); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
  <a href="https://wa.me/?text=<?php echo urlencode($url); ?>" target="_blank"><i class="fab fa-whatsapp"></i></a>
</div>