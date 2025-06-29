document.addEventListener('DOMContentLoaded', function() {
  // Elementos do DOM
  const botaoMenu = document.getElementById('botao-menu');
  const menuLateral = document.querySelector('.menu-lateral');
  
  // Controle do Menu
  botaoMenu.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    // Alternar estado do menu
    menuLateral.classList.toggle('ativo');
    
    // Atualizar ícone
    this.innerHTML = menuLateral.classList.contains('ativo') ? '✕' : '☰';
  });

  // Ajustar menu inicialmente baseado no tamanho da tela
  function ajustarMenuInicial() {
    if (window.innerWidth > 992) {
      menuLateral.classList.add('ativo');
      botaoMenu.innerHTML = '✕';
    } else {
      menuLateral.classList.remove('ativo');
      botaoMenu.innerHTML = '☰';
    }
  }

  // Executar no carregamento e redimensionamento
  ajustarMenuInicial();
  window.addEventListener('resize', ajustarMenuInicial);
});