document.addEventListener('DOMContentLoaded', function() {
    // ============ FUNÇÕES GERAIS ============
    // MENU
    const botaoMenu = document.getElementById('botao-menu');
    const menuLateral = document.getElementById('menuLateral');

    if (botaoMenu && menuLateral) {
        botaoMenu.addEventListener('click', () => {
            menuLateral.classList.toggle('ativo'); 
            botaoMenu.textContent = menuLateral.classList.contains('ativo') ? '✕' : '☰';
        });
    }

    // Toggle Password (para páginas de login)
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

    // Member Cards (para página de membros)
    document.querySelectorAll('.member-card').forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => this.style.transform = '', 200);
        });
    });

    // ============ FUNÇÕES DE MODAIS ============

    // Modal de Cadastro (para admin)
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

    // Modal de Exclusão -(para admin)
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
            
            // Apenas simulação, não remove realmente
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            closeModal();
        });
    };

    // Modal de Suporte (pra todos)
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

    // Modal de Upload (para admin)
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

    // Modal de Publicação (para admin)
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

    // Modal de Exclusão de Publicações
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
            
            // Apenas simulação, não remove realmente
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            closeModal();
        });
    };

    // ============ FUNÇÕES DA AGENDA - MEMBRO ============
    const setupAgendaMembro = () => {
    try {
        const eventos = [
            {
                id: 1,
                title: 'Submissão de trabalhos',
                start: '2025-07-18T00:00:00',
                end: '2023-08-18T23:59:59',
                className: 'success'
            },
            {
                id: 2,
                title: 'Reunião de Leitura',
                start: '2025-07-10T19:00:00',
                className: 'important'
            },
        ];

        let presencasTemporarias = {};

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            locale: 'pt-br',
            editable: false,
            selectable: false,
            eventLimit: true,
            height: 'auto',
            events: eventos,
            eventClick: function(event) {
                abrirModalEvento(event);
            }
        });

        // Elementos do modal de evento
        const modalEvento = document.getElementById('modalEvento');
        const modalTitulo = document.getElementById('modalEventoTitulo');
        const eventoTitulo = document.getElementById('evento-titulo');
        const eventoData = document.getElementById('evento-data');
        const eventoHorario = document.getElementById('evento-horario');
        const presencaStatus = document.getElementById('presenca-status');
        const statusText = document.getElementById('status-text');
        const btnPresente = document.getElementById('btn-presente');
        const btnAusente = document.getElementById('btn-ausente');
        const btnFechar = document.querySelector('.modal-evento-close');

        function abrirModalEvento(evento) {
            modalTitulo.textContent = evento.title;
            eventoTitulo.textContent = evento.title;
            
            const dataInicio = moment(evento.start);
            eventoData.textContent = dataInicio.format('DD/MM/YYYY');
            
            if (evento.start.hasTime()) {
                eventoHorario.textContent = dataInicio.format('HH:mm');
                if (evento.end) {
                    eventoHorario.textContent += ' - ' + moment(evento.end).format('HH:mm');
                }
            } else {
                eventoHorario.textContent = 'Dia todo';
            }
            
            const status = presencasTemporarias[evento.id] || 'nao_informado';
            atualizarStatusPresenca(status);
            
            btnPresente.onclick = function() {
                presencasTemporarias[evento.id] = 'presente';
                atualizarStatusPresenca('presente');
                alert('Presença marcada com sucesso!');
            };
            
            btnAusente.onclick = function() {
                presencasTemporarias[evento.id] = 'ausente';
                atualizarStatusPresenca('ausente');
                alert('Ausência registrada! ');
            };
            
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function atualizarStatusPresenca(status) {
            presencaStatus.className = 'presenca-status';
            if (status === 'presente') {
                presencaStatus.classList.add('presente');
                statusText.textContent = 'Confirmado';
            } else if (status === 'ausente') {
                presencaStatus.classList.add('ausente');
                statusText.textContent = 'Não vou comparecer';
            } else {
                statusText.textContent = 'Não informado';
            }
        }

        function fecharModalEvento() {
            modalEvento.classList.remove('active');
            document.body.style.overflow = '';
        }

        btnFechar.addEventListener('click', fecharModalEvento);
        modalEvento.addEventListener('click', (e) => {
            if (e.target === modalEvento) fecharModalEvento();
        });

    } catch (error) {
        console.error('Erro ao inicializar calendário:', error);
        $('#calendar').html('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
    }
};

    // Funções específicas para a agenda de admin
    const setupAgendaAdmin = () => {
    try {
        const eventosFixos = [
            {
                id: 1,
                title: 'Submissão de trabalhos',
                start: '2025-07-18T00:00:00',
                end: '2023-08-18T23:59:59',
                className: 'success'
            },
            {
                id: 2,
                title: 'Reunião de Leitura',
                start: '2025-07-10T19:00:00',
                className: 'important'
            },
        ];

        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            defaultDate: moment().format('YYYY-MM-DD'), 
            locale: 'pt-br',
            editable: true, 
            selectable: true,
            eventLimit: true,
            height: 'auto',
            contentHeight: 'auto',
            events: eventosFixos, 
            select: function(start, end) {
                abrirModalEventoAdmin({
                    start: start,
                    end: end
                });
            },
            eventClick: function(event) {
                abrirModalEventoAdmin(event);
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
            corSelect.value = evento.className || '';
            
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            formEvento.dataset.eventoId = evento.id || '';
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
                const eventoExistente = eventosFixos.find(e => e.id == novoEvento.id);
                if (eventoExistente) {
                    Object.assign(eventoExistente, novoEvento);
                }
                calendar.fullCalendar('updateEvent', novoEvento);
            } else {
                novoEvento.id = Math.max(...eventosFixos.map(e => e.id)) + 1;
                eventosFixos.push(novoEvento);
                calendar.fullCalendar('renderEvent', novoEvento, true);
            }

            fecharModalEventoAdmin();
        });

        if (btnAdicionarEvento) {
            btnAdicionarEvento.addEventListener('click', () => {
                abrirModalEventoAdmin({
                    start: new Date(),
                    end: moment().add(1, 'hour').toDate()
                });
            });
        }

    } catch (error) {
        console.error('Erro ao inicializar calendário admin:', error);
        $('#calendar').html('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
    }
};

    // ============ FÓRUM ============

    const forumData = {
    discussoes: [
        {
            id: 1,
            titulo: "Chat Geral",
            criador: "Fernanda Sehn",
            data: "10/07/2025",
            mensagens: 4,
            membrosComAcesso: ["all"]
        }
    ],
    membros: [
        { id: 1, nome: "Fernanda Sehn", cargo: "Admin" },
        { id: 2, nome: "Outro Membro", cargo: "Pesquisador" }
    ]
    };

    if (document.querySelector('.forum-admin-container') || window.location.pathname.includes('forum-admin.html')) {
        setupForum();
    }

    if (document.querySelector('.chat-container')) {
        setupChat();
    }

    function setupForum() {
        carregarDiscussoes();
        setupModalNovaDiscussao();
        setupModalExcluirDiscussao();
    }

    function setupChat() {
    const btnEnviar = document.querySelector('.btn-enviar');
    const chatInput = document.querySelector('.chat-input textarea');
    const chatMessages = document.querySelector('.chat-messages');

    if (btnEnviar && chatInput) {
        btnEnviar.addEventListener('click', function() {
            const messageText = chatInput.value.trim();
            if (messageText) {
                const newMessage = document.createElement('div');
                newMessage.className = 'message message-self';
                newMessage.innerHTML = `
                    <div class="message-header">
                        <img src="imagens/computer.jpg" alt="Você" class="message-avatar">
                        <div class="message-sender bolsista">Fernanda Sehn</div>
                    </div>
                    <div class="message-text">${messageText}</div>
                    <div class="message-time">${new Date().toLocaleString('pt-BR')}</div>
                `;
                
                chatMessages.appendChild(newMessage);
                
                chatInput.value = '';
                
                newMessage.scrollIntoView({ behavior: 'smooth' });
                
            }
        });
        
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                btnEnviar.click();
            }
        });
    }

    const btnEmoji = document.querySelector('.btn-emoji');
    if (btnEmoji) {
        btnEmoji.addEventListener('click', function() {
            alert('simulação: vai abrir um seletor de emojis');
        });
    }
    
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}

    function carregarDiscussoes() {
        const container = document.getElementById('discussoes-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        forumData.discussoes.forEach(discussao => {
            const discussaoHTML = `
                <div class="discussao-card">
                    <h4>${discussao.titulo}</h4>
                    <p>Criado por: ${discussao.criador}</p>
                    <div class="discussao-meta">
                        <span>${discussao.data}</span>
                        <span>${discussao.mensagens} mensagens</span>
                    </div>
                    <div class="discussao-acoes">
                        <button class="btn-acessar" data-id="${discussao.id}">Acessar</button>
                        ${isAdmin() ? `<button class="btn-excluir-discussao" data-id="${discussao.id}">Excluir</button>` : ''}
                    </div>
                </div>
            `;
            container.innerHTML += discussaoHTML;
        });
        
        document.querySelectorAll('.btn-acessar').forEach(btn => {
            btn.addEventListener('click', function() {
                const discussaoId = this.getAttribute('data-id');
                abrirDiscussao(discussaoId);
            });
        });
        
        if (isAdmin()) {
            document.querySelectorAll('.btn-excluir-discussao').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const discussaoId = this.getAttribute('data-id');
                    abrirModalExclusaoDiscussao(discussaoId);
                });
            });
        }
    }

    function setupModalNovaDiscussao() {
    console.log('Configurando modal de nova discussão...');
    const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
    const modal = document.getElementById('modalNovaDiscussao');
    
    if (!btnNovaDiscussao || !modal) {
        console.error('Elementos do modal não encontrados!');
        return;
    }
    
    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };
    
    const openModal = () => {
        const listaMembros = document.getElementById('listaMembros');
        if (!listaMembros) {
            console.error('Elemento listaMembros não encontrado!');
            return;
        }
        
        listaMembros.innerHTML = '';
        
        const membros = [
            { id: 1, nome: "Dr. Luciano Corsino", cargo: "Coordenador" },
            { id: 2, nome: "Dr. Daniel Santana", cargo: "Vice-Coordenador" },
            { id: 3, nome: "Fernanda Sehn", cargo: "Bolsista" },
            { id: 4, nome: "Danieri Ribeiro", cargo: "Membro" },
            { id: 5, nome: "Brenda Marins", cargo: "Bolsista" },
            { id: 6, nome: "Deisi Franco", cargo: "Bolsista" },
            { id: 7, nome: "Me. Leandro Mendes", cargo: "Membro" },
            { id: 8, nome: "Ma. Myllena Camargo", cargo: "Membro" }
        ];
        
        membros.forEach(membro => {
            const membroItem = document.createElement('div');
            membroItem.className = 'membro-item';
            
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.id = `membro-${membro.id}`;
            checkbox.name = 'membros';
            checkbox.value = membro.id;
            
            const label = document.createElement('label');
            label.htmlFor = `membro-${membro.id}`;
            label.textContent = `${membro.nome} (${membro.cargo})`;
            
            membroItem.appendChild(checkbox);
            membroItem.appendChild(label);
            listaMembros.appendChild(membroItem);
        });
        
        const selecionarTodos = document.getElementById('selecionarTodos');
        if (selecionarTodos) {
            selecionarTodos.addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#listaMembros input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        }
        
        listaMembros.style.display = 'block';
        listaMembros.style.visibility = 'visible';
        listaMembros.style.opacity = '1';
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    
    btnNovaDiscussao.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });
    
    document.querySelector('#modalNovaDiscussao .modal-close')?.addEventListener('click', closeModal);
    document.querySelector('#modalNovaDiscussao .cancel-button')?.addEventListener('click', closeModal);
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Submissão do formulário
    document.getElementById('formNovaDiscussao')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const titulo = document.getElementById('tituloDiscussao').value;
        const mensagem = document.getElementById('mensagemDiscussao').value;
        const membrosSelecionados = Array.from(
            document.querySelectorAll('#listaMembros input[type="checkbox"]:checked')
        ).map(el => el.value);
        
        if (!titulo) {
            alert('Por favor, insira um título para a discussão');
            return;
        }
        
        console.log('Nova discussão:', {
            titulo,
            mensagem,
            membrosSelecionados
        });
        
        alert('Discussão criada com sucesso!');
        closeModal();
        this.reset();
    });
}
// Modal Esqueceu Senha
const setupEsqueceuSenhaModal = () => {
    const forgotPasswordLink = document.querySelector('.forgot-password');
    const modalEsqueceuSenha = document.getElementById('modalEsqueceuSenha');
    
    if (!forgotPasswordLink || !modalEsqueceuSenha) return;

    const closeModal = () => {
        modalEsqueceuSenha.classList.remove('active');
        document.body.classList.remove('modal-open');
    };

    const openModal = (e) => {
        e.preventDefault();
        modalEsqueceuSenha.classList.add('active');
        document.body.classList.add('modal-open');
    };

    forgotPasswordLink.addEventListener('click', openModal);

    document.querySelectorAll('#modalEsqueceuSenha .close-modal').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    modalEsqueceuSenha.addEventListener('click', (e) => {
        if (e.target === modalEsqueceuSenha) closeModal();
    });

    document.getElementById('formEsqueceuSenha')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = document.getElementById('emailRecuperacao').value.trim();
        
        if (!email) {
            alert('Por favor, insira seu e-mail');
            return;
        }
        
        alert(`Instruções de recuperação de senha foram enviadas para: ${email}`);
        closeModal();
    });
};

if (document.querySelector('.forgot-password')) setupEsqueceuSenhaModal();

    function setupModalExcluirDiscussao() {
        const modal = document.getElementById('modalExcluirDiscussao');
        if (!modal) return;
        
        let discussaoIdParaExcluir = null;
        
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };
        
        const abrirModalExclusaoDiscussao = (id) => {
            discussaoIdParaExcluir = id;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        
        document.getElementById('cancelarExclusaoDiscussao')?.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        
        document.getElementById('confirmarExclusaoDiscussao')?.addEventListener('click', () => {
            if (discussaoIdParaExcluir) {
                carregarDiscussoes();
                alert('Discussão excluída com sucesso!');
            }
            closeModal();
        });
        
        window.abrirModalExclusaoDiscussao = abrirModalExclusaoDiscussao;
    }

    function abrirDiscussao(id) {
        const discussao = forumData.discussoes.find(d => d.id == id);
        if (!discussao) return;
        
        window.location.href = `discussao-ex.html?id=${id}`;
    }

    function isAdmin() {
        return true; 
    }

// Função para edição de biografia
const setupBiografiaEdicao = () => {
    const editButton = document.querySelector('.edit-text');
    const sobreTexto = document.querySelector('.sobre-texto');
    
    if (!editButton || !sobreTexto) return;

    let originalContent = '';

    editButton.addEventListener('click', () => {
        originalContent = sobreTexto.innerHTML;
        
        sobreTexto.classList.add('editing');
        
        const elementosEditaveis = sobreTexto.querySelectorAll('h4, p, li');
        elementosEditaveis.forEach(el => {
            el.setAttribute('contenteditable', 'true');
        });
        
        const buttonsDiv = document.createElement('div');
        buttonsDiv.className = 'edit-buttons';
        buttonsDiv.innerHTML = `
            <button class="btn-salvar">Salvar Alterações</button>
            <button class="btn-cancelar">Cancelar</button>
        `;
        
        sobreTexto.appendChild(buttonsDiv);
        
        buttonsDiv.querySelector('.btn-salvar').addEventListener('click', () => {
            sobreTexto.classList.remove('editing');
            elementosEditaveis.forEach(el => {
                el.removeAttribute('contenteditable');
            });
            
            buttonsDiv.remove();
            
            alert('Alterações salvas com sucesso! (Simulação)');
            
        });
        
        buttonsDiv.querySelector('.btn-cancelar').addEventListener('click', () => {
            sobreTexto.innerHTML = originalContent;
            sobreTexto.classList.remove('editing');
            
            setupBiografiaEdicao();
        });
    });
};

setupBiografiaEdicao();

    // ============ INICIALIZAÇÃO ============
    if (document.getElementById('calendar')) {
        if (document.querySelector('.btn-adicionar')) {
            setupAgendaAdmin();
        } else {
            setupAgendaMembro();
        }
    }
    
    if (document.querySelector('.btn-adicionar')) setupPublicacaoModal();
    if (document.querySelector('.add-member-button')) setupCadastroModal();
    if (document.querySelector('.delete-member-button')) setupExclusaoModal();
    if (document.querySelector('.btn-excluir')) setupExclusaoPublicacaoModal();
    if (document.getElementById('supportForm')) setupSupportModal();
    if (document.querySelector('.add-file-button')) setupUploadModal();
    if (document.querySelector('#carouselExample')) setupCarousel();
});