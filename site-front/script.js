document.addEventListener('DOMContentLoaded', function() {
    const botaoMenu = document.getElementById('botao-menu');
    const menuLateral = document.getElementById('menuLateral');

    if (botaoMenu && menuLateral) {
        botaoMenu.addEventListener('click', () => {
            menuLateral.classList.toggle('ativo'); 

            if (menuLateral.classList.contains('ativo')) {
                botaoMenu.textContent = '✕'; 
            } else {
                botaoMenu.textContent = '☰'; 
            }
        });
    }

    const loginForm = document.getElementById('loginForm');
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.innerHTML = type === 'password' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>' :
                '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
        });
    }
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username) {
                alert('Por favor, insira seu nome de usuário');
                return;
            }
            
            if (!password) {
                alert('Por favor, insira sua senha');
                return;
            }
            
            alert('Login válido! (Simulação)');
        });
    }

    const memberCards = document.querySelectorAll('.member-card');
    if (memberCards.length > 0) {
        memberCards.forEach(card => {
            card.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
                
            });
        });
    }

const addMemberButton = document.querySelector('.add-member-button');
const modalOverlay = document.getElementById('modalCadastro');
const closeModalButton = document.querySelector('.close-modal');
const cancelButton = document.querySelector('.cancel-button');

addMemberButton.addEventListener('click', (e) => {
  e.preventDefault();
  document.body.classList.add('modal-open');
  modalOverlay.classList.add('active');
});

function closeModal() {
  document.body.classList.remove('modal-open');
  modalOverlay.classList.remove('active');
}

closeModalButton.addEventListener('click', closeModal);
cancelButton.addEventListener('click', closeModal);
modalOverlay.addEventListener('click', (e) => {
  if (e.target === modalOverlay) {
    closeModal();
  }
});

document.getElementById('formCadastroMembro').addEventListener('submit', (e) => {
  e.preventDefault();
  
  const nome = document.getElementById('nomeMembro').value;
  const email = document.getElementById('emailMembro').value;
  const cargo = document.getElementById('cargoMembro').value;
  
  console.log('Novo membro:', { nome, email, cargo });
  
  closeModal();
  
  alert('Membro cadastrado com sucesso!');
});

// Modal de Exclusão de Membro - NOVO CÓDIGO ADICIONADO
    const deleteMemberButton = document.querySelector('.delete-member-button');
    const modalExcluirOverlay = document.getElementById('modalExcluirMembro');
    const cancelarExclusaoButton = document.getElementById('cancelarExclusao');
    const confirmarExclusaoButton = document.getElementById('confirmarExclusao');
    const closeExcluirModalButton = document.querySelector('#modalExcluirMembro .close-modal');

    if (deleteMemberButton && modalExcluirOverlay) {
        deleteMemberButton.addEventListener('click', (e) => {
            e.preventDefault();
            
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecione pelo menos um membro para excluir.');
                return;
            }
            
            document.body.classList.add('modal-open');
            modalExcluirOverlay.classList.add('active');
        });

        function closeDeleteModal() {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
        }

        if (cancelarExclusaoButton) {
            cancelarExclusaoButton.addEventListener('click', closeDeleteModal);
        }

        if (confirmarExclusaoButton) {
            confirmarExclusaoButton.addEventListener('click', () => {
                const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            
                closeDeleteModal();
                alert(`${checkboxes.length} membro(s) excluído(s) com sucesso!`);
            });
        }

        if (closeExcluirModalButton) {
            closeExcluirModalButton.addEventListener('click', closeDeleteModal);
        }

        modalExcluirOverlay.addEventListener('click', (e) => {
            if (e.target === modalExcluirOverlay) {
                closeDeleteModal();
            }
        });
    }

const supportForm = document.getElementById('supportForm');
const modalConfirmacao = document.getElementById('modalConfirmacao');
const fecharConfirmacao = document.getElementById('fecharConfirmacao');
const closeModalBtn = document.querySelector('#modalConfirmacao .close-modal');

function openConfirmationModal() {
  document.body.classList.add('modal-open');
  modalConfirmacao.classList.add('active');
}

function closeConfirmationModal() {
  document.body.classList.remove('modal-open');
  modalConfirmacao.classList.remove('active');
}

if (supportForm) {
  supportForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const mensagem = document.getElementById('mensagem').value.trim();
    
    if (!nome || !email || !mensagem) {
      alert('Por favor, preencha todos os campos obrigatórios.');
      return;
    }
    
    openConfirmationModal();
  });
}

if (fecharConfirmacao) fecharConfirmacao.addEventListener('click', closeConfirmationModal);
if (closeModalBtn) closeModalBtn.addEventListener('click', closeConfirmationModal);

if (modalConfirmacao) {
  modalConfirmacao.addEventListener('click', function(e) {
    if (e.target === modalConfirmacao) {
      closeConfirmationModal();
    }
  });
}
});