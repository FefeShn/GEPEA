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

    // ============ FUNÇÕES DO FÓRUM ============

    // Dados simulados (substituir por API real depois)
    const forumData = {
        discussoes: [
            {
                id: 1,
                titulo: "Planejamento do próximo encontro",
                criador: "Dr. Luciano Corsino",
                data: "15/03/2025",
                mensagens: 12,
                membrosComAcesso: ["all"],
                mensagens: [
                    {
                        id: 1,
                        sender: "Dr. Luciano Corsino",
                        text: "Vamos marcar nosso próximo encontro para discutir o capítulo 3 do livro.",
                        time: "15/03/2025 10:30",
                        isCurrentUser: false
                    },
                    {
                        id: 2,
                        sender: "Fernanda Sehn",
                        text: "Prefiro na semana que vem, na quarta-feira.",
                        time: "15/03/2025 11:45",
                        isCurrentUser: true
                    }
                ]
            },
            {
                id: 2,
                titulo: "Divisão de tarefas para o evento",
                criador: "Danieri Ribeiro",
                data: "10/03/2025",
                mensagens: 8,
                membrosComAcesso: [1, 3, 5], // IDs dos membros
                mensagens: [
                    {
                        id: 1,
                        sender: "Danieri Ribeiro",
                        text: "Precisamos dividir quem vai cuidar de cada parte do evento.",
                        time: "10/03/2025 09:15",
                        isCurrentUser: false
                    }
                ]
            }
        ],
        membros: [
            { id: 1, nome: "Dr. Luciano Corsino", cargo: "Coordenador" },
            { id: 2, nome: "Dr. Daniel Santana", cargo: "Vice-Coordenador" },
            { id: 3, nome: "Fernanda Sehn", cargo: "Bolsista" },
            { id: 4, nome: "Danieri Ribeiro", cargo: "Membro" },
            { id: 5, nome: "Brenda Marins", cargo: "Bolsista" },
            { id: 6, nome: "Deisi Franco", cargo: "Bolsista" },
            { id: 7, nome: "Me. Leandro Mendes", cargo: "Membro" },
            { id: 8, nome: "Ma. Myllena Camargo", cargo: "Membro" }
        ]
    };

    // Verifica se está na página do fórum
    if (window.location.pathname.includes('forum-admin.html')) {
        setupForum();
    }

    // Verifica se está na página de discussão
    if (document.querySelector('.chat-container')) {
        setupChat();
    }

    function setupForum() {
        // Carrega as discussões
        carregarDiscussoes();
        
        // Configura o modal de nova discussão
        setupModalNovaDiscussao();
        
        // Configura o modal de exclusão (só para admin)
        setupModalExcluirDiscussao();
    }

    function setupChat() {
        // Simulação de envio de mensagem
        const btnEnviar = document.querySelector('.btn-enviar');
        const chatInput = document.querySelector('.chat-input textarea');
        const chatMessages = document.querySelector('.chat-messages');

        if (btnEnviar && chatInput) {
            btnEnviar.addEventListener('click', function() {
                const messageText = chatInput.value.trim();
                if (messageText) {
                    // Cria nova mensagem
                    const newMessage = document.createElement('div');
                    newMessage.className = 'message message-self';
                    newMessage.innerHTML = `
                        <div class="message-sender">Você</div>
                        <div class="message-text">${messageText}</div>
                        <div class="message-time">${new Date().toLocaleString('pt-BR')}</div>
                    `;
                    
                    // Adiciona ao chat
                    chatMessages.appendChild(newMessage);
                    
                    // Limpa o input
                    chatInput.value = '';
                    
                    // Rola para a nova mensagem
                    newMessage.scrollIntoView({ behavior: 'smooth' });
                    
                    // Simula resposta após 1-2 segundos
                    setTimeout(() => {
                        const replies = [
                            "Ótima sugestão!",
                            "Vamos considerar isso na próxima reunião.",
                            "Concordo plenamente.",
                            "Precisamos discutir isso com mais detalhes."
                        ];
                        const randomReply = replies[Math.floor(Math.random() * replies.length)];
                        
                        const replyMessage = document.createElement('div');
                        replyMessage.className = 'message message-other';
                        replyMessage.innerHTML = `
                            <div class="message-sender">Dr. Luciano Corsino</div>
                            <div class="message-text">${randomReply}</div>
                            <div class="message-time">${new Date().toLocaleString('pt-BR')}</div>
                        `;
                        
                        chatMessages.appendChild(replyMessage);
                        replyMessage.scrollIntoView({ behavior: 'smooth' });
                    }, 1000 + Math.random() * 1000);
                }
            });
            
            // Permite enviar com Enter (Shift+Enter para nova linha)
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    btnEnviar.click();
                }
            });
        }

        // Botão de emoji (simulação)
        const btnEmoji = document.querySelector('.btn-emoji');
        if (btnEmoji) {
            btnEmoji.addEventListener('click', function() {
                alert('Em um sistema real, isso abriria um seletor de emojis');
            });
        }
        
        // Rolagem automática para a última mensagem
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
        
        // Adiciona eventos aos botões
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
        const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
        const modal = document.getElementById('modalNovaDiscussao');
        
        if (!btnNovaDiscussao || !modal) return;
        
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };
        
        const openModal = () => {
            // Carrega a lista de membros
            const listaMembros = document.getElementById('listaMembros');
            listaMembros.innerHTML = '';
            
            forumData.membros.forEach(membro => {
                const membroHTML = `
                    <div class="membro-item">
                        <input type="checkbox" id="membro-${membro.id}" name="membros" value="${membro.id}">
                        <label for="membro-${membro.id}">${membro.nome} (${membro.cargo})</label>
                    </div>
                `;
                listaMembros.innerHTML += membroHTML;
            });
            
            // Configura o "Selecionar todos"
            document.getElementById('selecionarTodos').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('#listaMembros input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
            
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        
        btnNovaDiscussao.addEventListener('click', openModal);
        
        // Fechar modal
        document.querySelector('#modalNovaDiscussao .modal-close').addEventListener('click', closeModal);
        document.querySelector('#modalNovaDiscussao .cancel-button').addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        
        // Formulário de nova discussão
        document.getElementById('formNovaDiscussao')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const titulo = document.getElementById('tituloDiscussao').value;
            const mensagem = document.getElementById('mensagemDiscussao').value;
            const membrosSelecionados = Array.from(document.querySelectorAll('#listaMembros input:checked')).map(el => el.value);
            
            // Simula a criação de uma nova discussão
            const novaDiscussao = {
                id: forumData.discussoes.length + 1,
                titulo: titulo,
                criador: "Usuário Atual", // Substituir pelo nome real
                data: new Date().toLocaleDateString('pt-BR'),
                mensagens: mensagem ? 1 : 0,
                membrosComAcesso: membrosSelecionados.length > 0 ? membrosSelecionados : ["all"],
                mensagens: mensagem ? [{
                    id: 1,
                    sender: "Usuário Atual",
                    text: mensagem,
                    time: new Date().toLocaleString('pt-BR'),
                    isCurrentUser: true
                }] : []
            };
            
            forumData.discussoes.push(novaDiscussao);
            carregarDiscussoes();
            closeModal();
            this.reset();
            
            alert('Discussão criada com sucesso!');
        });
    }

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
                // Simula a exclusão
                forumData.discussoes = forumData.discussoes.filter(d => d.id != discussaoIdParaExcluir);
                carregarDiscussoes();
                alert('Discussão excluída com sucesso!');
            }
            closeModal();
        });
        
        window.abrirModalExclusaoDiscussao = abrirModalExclusaoDiscussao;
    }

    function abrirDiscussao(id) {
        // Em uma implementação real, isso redirecionaria para discussao.html com o ID
        const discussao = forumData.discussoes.find(d => d.id == id);
        if (!discussao) return;
        
        // Simulação - em produção seria um redirecionamento
        window.location.href = `discussao-ex.html?id=${id}`;
    }

    function isAdmin() {
        // Simula verificação se o usuário é admin
        // Na implementação real, isso viria do sistema de login
        return true; // ou false para membros comuns
    }

    // ============ INICIALIZAÇÃO ============
    setupPublicacaoModal();
    setupCadastroModal();
    setupExclusaoModal(); 
    setupExclusaoPublicacaoModal();
    setupSupportModal();
    setupUploadModal();
    setupCarousel();
});