document.addEventListener('DOMContentLoaded', function() {
    // Menu Lateral
    const botaoMenu = document.getElementById('botao-menu');
    const menuLateral = document.getElementById('menuLateral');

    if (botaoMenu && menuLateral) {
        botaoMenu.addEventListener('click', () => {
            menuLateral.classList.toggle('ativo'); 
            botaoMenu.textContent = menuLateral.classList.contains('ativo') ? '✕' : '☰';
        });
    }

    // Toggle Password
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

    // Login Form
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (!username) alert('Por favor, insira seu nome de usuário');
            else if (!password) alert('Por favor, insira sua senha');
            else alert('Login válido! (Simulação)');
        });
    }

    // Member Cards
    document.querySelectorAll('.member-card').forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => this.style.transform = '', 200);
        });
    });

    // Modal de Cadastro
    const setupCadastroModal = () => {
        const addMemberButton = document.querySelector('.add-member-button');
        const modalOverlay = document.getElementById('modalCadastro');
        
        if (!addMemberButton || !modalOverlay) return;

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalOverlay.classList.remove('active');
        };

        addMemberButton.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.add('modal-open');
            modalOverlay.classList.add('active');
        });

        document.querySelectorAll('.close-modal, .cancel-button').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });

        document.getElementById('formCadastroMembro')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const nome = document.getElementById('nomeMembro').value;
            const email = document.getElementById('emailMembro').value;
            const cargo = document.getElementById('cargoMembro').value;
            console.log('Novo membro:', { nome, email, cargo });
            closeModal();
            alert('Membro cadastrado com sucesso!');
        });
    };

    // Modal de Exclusão - Versão Refatorada
const setupExclusaoModal = () => {
    const deleteButton = document.getElementById('openDeleteModal');
    const modalExcluirOverlay = document.getElementById('modalExcluirMembro');
    
    if (!deleteButton || !modalExcluirOverlay) {
        console.error('Elementos do modal de exclusão não encontrados!');
        return;
    }

    const closeModal = () => {
        document.body.classList.remove('modal-open');
        modalExcluirOverlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    const openModal = () => {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Por favor, selecione pelo menos um arquivo para excluir.');
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

    // Event Listeners para fechar modal
    document.getElementById('cancelarExclusao')?.addEventListener('click', closeModal);
    document.querySelector('#modalExcluirMembro .modal-close')?.addEventListener('click', closeModal);

    // Fechar modal ao clicar no overlay ou pressionar ESC
    modalExcluirOverlay.addEventListener('click', (e) => {
        if (e.target === modalExcluirOverlay) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modalExcluirOverlay.classList.contains('active')) {
            closeModal();
        }
    });

    document.getElementById('confirmarExclusao')?.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        alert(`${checkboxes.length} arquivo(s) excluído(s) com sucesso!`);
        closeModal();
        
        // Aqui você pode adicionar a lógica real de exclusão
        // checkboxes.forEach(checkbox => {
        //     const fileId = checkbox.dataset.fileId;
        //     // Chamada AJAX para excluir o arquivo
        // });
    });
};

    // Modal de Suporte
    const setupSupportModal = () => {
        const supportForm = document.getElementById('supportForm');
        const modalConfirmacao = document.getElementById('modalConfirmacao');
        
        if (!supportForm || !modalConfirmacao) return;

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalConfirmacao.classList.remove('active');
        };

        supportForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const nome = document.getElementById('nome').value.trim();
            const email = document.getElementById('email').value.trim();
            const mensagem = document.getElementById('mensagem').value.trim();
            
            if (!nome || !email || !mensagem) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }
            document.body.classList.add('modal-open');
            modalConfirmacao.classList.add('active');
        });

        document.querySelectorAll('#fecharConfirmacao, #modalConfirmacao .close-modal').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalConfirmacao.addEventListener('click', (e) => {
            if (e.target === modalConfirmacao) closeModal();
        });
    };

    // Modal de Upload
    const setupUploadModal = () => {
        const openModalButton = document.querySelector('.add-file-button');
        const modalUpload = document.getElementById('modalUpload');
        
        if (!openModalButton || !modalUpload) {
            console.error('Elementos do modal de upload não encontrados!');
            return;
        }

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalUpload.classList.remove('active');
        };

        openModalButton.addEventListener('click', (e) => {
            e.preventDefault();
            console.log('Abrindo modal de upload...');
            document.body.classList.add('modal-open');
            modalUpload.classList.add('active');
        });

        document.querySelectorAll('#modalUpload .close-modal, #modalUpload .cancel-button').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalUpload.addEventListener('click', (e) => {
            if (e.target === modalUpload) closeModal();
        });

        document.getElementById('uploadForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const fileName = document.getElementById('fileTitle').value;
            alert(`Arquivo "${fileName}" enviado com sucesso!`);
            closeModal();
        });
    };

    // Inicializa todos os modais
    setupCadastroModal();
    setupExclusaoModal();
    setupSupportModal();
    setupUploadModal();
});