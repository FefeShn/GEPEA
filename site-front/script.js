document.addEventListener('DOMContentLoaded', () => {
  const botaoMenu = document.getElementById('botao-menu');
  const menuLateral = document.getElementById('menuLateral');

  botaoMenu.addEventListener('click', () => {
    menuLateral.classList.toggle('ativo'); 

    if (menuLateral.classList.contains('ativo')) {
      botaoMenu.textContent = '✕'; 
    } else {
      botaoMenu.textContent = '☰'; 
    }
  });
});
