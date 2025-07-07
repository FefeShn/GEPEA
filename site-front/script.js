document.addEventListener('DOMContentLoaded', function() {
    // ============ FUNÇÕES GERAIS ============
    
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

    // ============ FUNÇÕES DE MODAIS ============

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

    // Modal de Exclusão - VERSÃO SIMULADA (sem remoção real)
    const setupExclusaoModal = () => {
        const deleteButton = document.querySelector('.delete-member-button');
        const modalExcluirOverlay = document.getElementById('modalExcluirMembro');
        
        if (!deleteButton || !modalExcluirOverlay) {
            console.error('Elementos do modal de exclusão não encontrados!');
            return;
        }

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            // Limpa as seleções ao fechar o modal
            document.querySelectorAll('.member-checkbox:checked').forEach(checkbox => {
                checkbox.checked = false;
            });
        };

        const openModal = () => {
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecione pelo menos um membro para excluir.');
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

        document.getElementById('cancelarExclusao')?.addEventListener('click', closeModal);

        modalExcluirOverlay.addEventListener('click', (e) => {
            if (e.target === modalExcluirOverlay) closeModal();
        });

        document.getElementById('confirmarExclusao')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.member-checkbox:checked');
            alert(`Simulação: ${checkboxes.length} membro(s) marcado(s) para exclusão!`);
            
            // Apenas simulação - não remove realmente
            checkboxes.forEach(checkbox => {
                checkbox.checked = false; // Desmarca os checkboxes
            });
            
            closeModal();
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

    // Modal de Publicação
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

        document.getElementById('formPublicacao')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const titulo = document.getElementById('tituloPublicacao').value;
            const resumo = document.getElementById('resumoPublicacao').value;
            const imagem = document.getElementById('imagemPublicacao').files[0];
            
            console.log('Nova publicação:', { titulo, resumo, imagem });
            alert('Publicação criada com sucesso!');
            
            e.target.reset();
            closeModal();
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

    // Carrossel
    const setupCarousel = () => {
        const carousel = document.querySelector('#carouselExample');
        if (!carousel) return;

        const items = carousel.querySelectorAll('.carousel-item');
        if (items.length === 0) return;

        let currentIndex = 0;
        let isTransitioning = false;
        
        function showItem(index) {
            if (isTransitioning || index === currentIndex) return;
            
            isTransitioning = true;
            
            items[currentIndex].classList.remove('active');
            items[index].classList.add('active');
            
            updateIndicators(index);
            
            currentIndex = index;
            
            setTimeout(() => {
                isTransitioning = false;
            }, 800);
        }
        
        function updateIndicators(index) {
            const indicators = document.querySelectorAll('.carousel-indicator');
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
            });
        }
        
        carousel.querySelector('.carousel-control-next')?.addEventListener('click', () => {
            const nextIndex = (currentIndex + 1) % items.length;
            showItem(nextIndex);
        });
        
        carousel.querySelector('.carousel-control-prev')?.addEventListener('click', () => {
            const prevIndex = (currentIndex - 1 + items.length) % items.length;
            showItem(prevIndex);
        });
        
        const indicatorsContainer = document.createElement('div');
        indicatorsContainer.className = 'carousel-indicators';
        
        items.forEach((_, index) => {
            const indicator = document.createElement('button');
            indicator.className = `carousel-indicator ${index === 0 ? 'active' : ''}`;
            indicator.addEventListener('click', () => showItem(index));
            indicatorsContainer.appendChild(indicator);
        });
        
        carousel.appendChild(indicatorsContainer);
        
        showItem(0);
    };

    // ============ FUNÇÕES DA AGENDA ============

    // Inicializa o calendário com tratamento de erros
    if (document.getElementById('calendar')) {
        try {
            console.log('Inicializando FullCalendar...');
            
            // Verifique se jQuery e FullCalendar estão carregados
            if (!window.jQuery || !$.fullCalendar) {
                throw new Error('Bibliotecas necessárias não carregadas');
            }

            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                locale: 'pt-br',
                editable: true,
                selectable: true,
                eventLimit: true,
                height: 'auto',
                contentHeight: 'auto',
                events: [
                    {
                        title: 'Reunião de Planejamento',
                        start: new Date(),
                        className: 'important'
                    },
                    {
                        title: 'Evento Semanal',
                        start: moment().add(3, 'days').hour(14).minute(0),
                        end: moment().add(3, 'days').hour(16).minute(0),
                        className: 'info'
                    }
                ],
                select: function(start, end) {
                    abrirModalEvento({
                        start: start,
                        end: end
                    });
                },
                eventClick: function(event) {
                    abrirModalEvento(event);
                }
            });

            console.log('Calendário inicializado com sucesso!');
        } catch (error) {
            console.error('Erro ao inicializar calendário:', error);
            // Mostra mensagem de erro para o usuário
            $('#calendar').html('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
        }

        // Elementos do modal de evento
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

        // Função para abrir o modal de evento
        function abrirModalEvento(evento) {
            modalTitulo.textContent = evento.title ? 'Editar Evento' : 'Novo Evento';
            tituloInput.value = evento.title || '';
            dataInicioInput.value = moment(evento.start).format('YYYY-MM-DDTHH:mm');
            dataFimInput.value = evento.end ? moment(evento.end).format('YYYY-MM-DDTHH:mm') : '';
            corSelect.value = evento.className || '';
            
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            formEvento.dataset.eventoId = evento.id || '';
        }

        // Fechar modal de evento
        function fecharModalEvento() {
            modalEvento.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Event listeners do modal de evento
        btnCancelar.addEventListener('click', fecharModalEvento);
        btnFechar.addEventListener('click', fecharModalEvento);
        modalEvento.addEventListener('click', (e) => {
            if (e.target === modalEvento) fecharModalEvento();
        });

        // Submit do formulário de evento
        formEvento.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const novoEvento = {
                title: tituloInput.value,
                start: dataInicioInput.value,
                end: dataFimInput.value || null,
                className: corSelect.value || ''
            };

            if (formEvento.dataset.eventoId) {
                novoEvento.id = formEvento.dataset.eventoId;
                calendar.fullCalendar('updateEvent', novoEvento);
            } else {
                calendar.fullCalendar('renderEvent', novoEvento, true);
            }

            fecharModalEvento();
        });

        // Botão Adicionar Evento
        if (btnAdicionarEvento) {
            btnAdicionarEvento.addEventListener('click', () => {
                abrirModalEvento({
                    start: new Date(),
                    end: moment().add(1, 'hour').toDate()
                });
            });
        }
    }

    // Modal de Exclusão de Publicações - VERSÃO SIMULADA
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
        
        // Limpa as seleções ao fechar o modal
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

    document.getElementById('confirmarExclusaoPubli')?.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
        alert(`Simulação: ${checkboxes.length} publicação(ões) marcada(s) para exclusão!`);
        
        // Apenas simulação - não remove realmente
        checkboxes.forEach(checkbox => {
            checkbox.checked = false; // Desmarca os checkboxes
        });
        
        closeModal();
    });
};
    // ============ INICIALIZAÇÃO ============
    setupPublicacaoModal();
    setupCadastroModal();
    setupExclusaoModal(); 
    setupExclusaoPublicacaoModal();
    setupSupportModal();
    setupUploadModal();
    setupCarousel();
});