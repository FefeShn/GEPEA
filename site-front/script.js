document.addEventListener('DOMContentLoaded', () => {
  const botaoMenu = document.getElementById('botao-menu');
  const menuLateral = document.getElementById('menuLateral');

  botaoMenu.addEventListener('click', () => {
    menuLateral.classList.toggle('ativo'); // adiciona ou remove a classe 'ativo'

    if (menuLateral.classList.contains('ativo')) {
      botaoMenu.textContent = '✕'; // ícone de fechar
    } else {
      botaoMenu.textContent = '☰'; // ícone de abrir
    }
  });
});
