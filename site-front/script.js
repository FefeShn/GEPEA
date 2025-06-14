document.addEventListener('DOMContentLoaded', () => {
  const botaoMenu = document.getElementById('botao-menu');
  const menuLateral = document.querySelector('nav.menu-lateral');

  botaoMenu.addEventListener('click', () => {
    menuLateral.classList.toggle('ativo');
  });

  // Busca simples para filtrar cards
  const inputBusca = document.getElementById('navbar-search-input');
  const cards = document.querySelectorAll('.card');

  inputBusca.addEventListener('input', () => {
    const textoBusca = inputBusca.value.toLowerCase();

    cards.forEach(card => {
      const titulo = card.querySelector('.card-title').textContent.toLowerCase();
      const texto = card.querySelector('.card-text').textContent.toLowerCase();

      if (titulo.includes(textoBusca) || texto.includes(textoBusca)) {
        card.parentElement.style.display = '';
      } else {
        card.parentElement.style.display = 'none';
      }
    });
  });
});
