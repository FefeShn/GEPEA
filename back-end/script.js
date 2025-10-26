function setupPostCarousel() {
    const carousel = document.getElementById('postCarousel');
    if (!carousel) return;

    const inner = carousel.querySelector('.carousel-inner');
    const items = carousel.querySelectorAll('.carousel-item');
    const indicators = carousel.querySelectorAll('.indicator');
    
    if (items.length <= 1) return;

    let currentIndex = 0;
    let isTransitioning = false;

    function showSlide(index) {
        if (isTransitioning || index < 0 || index >= items.length) return;
        
        isTransitioning = true;
        inner.style.transform = `translateX(-${index * 100}%)`;
        
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        
        items.forEach((item, i) => {
            item.classList.toggle('active', i === index);
        });
        
        currentIndex = index;
        
        setTimeout(() => {
            isTransitioning = false;
        }, 500);
    }

    function moveSlide(direction) {
        let newIndex = currentIndex + direction;
        
        if (newIndex < 0) {
            newIndex = items.length - 1;
        } else if (newIndex >= items.length) {
            newIndex = 0;
        }
        
        showSlide(newIndex);
    }

    function goToSlide(index) {
        if (index >= 0 && index < items.length) {
            showSlide(index);
        }
    }

    carousel.querySelector('.prev').addEventListener('click', () => moveSlide(-1));
    carousel.querySelector('.next').addEventListener('click', () => moveSlide(1));

    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => goToSlide(index));
    });

    showSlide(0);
}
document.addEventListener('DOMContentLoaded', function() {
    const botaoMenu = document.getElementById('botao-menu');
    const menuLateral = document.getElementById('menuLateral');

    if (botaoMenu && menuLateral) {
        botaoMenu.addEventListener('click', () => {
            menuLateral.classList.toggle('ativo'); 
            botaoMenu.textContent = menuLateral.classList.contains('ativo') ? '✕' : '☰';
        });
    }

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

    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            
            if (!email) {
                alert('Por favor, insira seu e-mail');
                e.preventDefault();
            } else if (!password) {
                alert('Por favor, insira sua senha');
                e.preventDefault();
            }
        });
    }

    document.querySelectorAll('.member-card').forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => this.style.transform = '', 200);
        });
    });

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

        document.getElementById('confirmarExclusao')?.addEventListener('click', async () => {
            const selected = Array.from(document.querySelectorAll('.member-checkbox:checked'));
            if (selected.length === 0) {
                alert('Nenhum membro selecionado.');
                return;
            }
            const ids = selected.map(cb => parseInt(cb.value, 10)).filter(n => Number.isFinite(n));
            if (ids.length === 0) {
                alert('Seleção inválida.');
                return;
            }
            try {
                const resp = await fetch('api/membros_excluir.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids })
                });
                const data = await resp.json().catch(() => ({ ok: false, error: 'Falha ao interpretar resposta' }));
                if (!resp.ok || !data.ok) {
                    throw new Error(data.error || 'Erro ao excluir membros');
                }
                // Remover cartões da interface
                selected.forEach(cb => {
                    const wrapper = cb.closest('.member-card-wrapper');
                    if (wrapper) wrapper.remove();
                });
                closeModal();
            } catch (err) {
                console.error(err);
                alert('Erro: ' + (err && err.message ? err.message : 'Não foi possível excluir.'));
            }
        });
    };

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

        // Toggle Arquivo/Link no modal
        const tipoRadios = modalUpload.querySelectorAll('input[name="tipo"]');
        const groupArquivo = modalUpload.querySelector('.group-arquivo');
        const groupLink = modalUpload.querySelector('.group-link');
        const fileInput = modalUpload.querySelector('#fileUpload');
        const linkInput = modalUpload.querySelector('#linkUrl');

        const applyTipo = () => {
            const tipo = modalUpload.querySelector('input[name="tipo"]:checked')?.value || 'arquivo';
            const isLink = tipo === 'link';
            if (groupArquivo) groupArquivo.style.display = isLink ? 'none' : '';
            if (groupLink) groupLink.style.display = isLink ? '' : 'none';
            if (fileInput) fileInput.required = !isLink;
            if (linkInput) linkInput.required = isLink;
        };
        tipoRadios.forEach(r => r.addEventListener('change', applyTipo));
        applyTipo();

        document.getElementById('uploadForm')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const form = document.getElementById('uploadForm');
                const fd = new FormData(form);
                const tipo = fd.get('tipo') || 'arquivo';
                if (tipo === 'link') {
                    // Evita enviar campo de arquivo vazio
                    fd.delete('arquivo');
                }
                const resp = await fetch('./api/arquivos_upload.php', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                const data = await resp.json().catch(async () => {
                    const txt = await resp.text().catch(() => '');
                    return { ok: false, error: txt || 'Falha ao interpretar resposta' };
                });
                if (!resp.ok || !data.ok) throw new Error(data.error || 'Erro no upload');
                closeModal();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Erro no upload: ' + (err && err.message ? err.message : 'Não foi possível enviar. Verifique o tamanho do arquivo (upload_max_filesize/post_max_size) e tente novamente.'));
            }
        });
    };

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

        document.getElementById('formPublicacao')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const titulo = document.getElementById('tituloPublicacao').value.trim();
            if (!titulo) { alert('Informe um título.'); return; }
            const fd = new FormData(form);
            try {
                const resp = await fetch('./api/publicacoes_criar.php', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                const data = await resp.json();
                if (!resp.ok || !data.ok) throw new Error(data.error || 'Falha ao criar publicação');
                form.reset();
                closeModal();
                window.location.href = data.redirect;
            } catch (err) {
                console.error(err);
                alert('Erro ao criar publicação.');
            }
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

        document.getElementById('confirmarExclusaoPubli')?.addEventListener('click', async () => {
            const checkboxes = Array.from(document.querySelectorAll('.publi-checkbox:checked'));
            const ids = checkboxes.map(cb => parseInt(cb.value, 10)).filter(Boolean);
            if (ids.length === 0) { closeModal(); return; }
            try {
                const resp = await fetch('./api/publicacoes_excluir.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ids }) });
                const data = await resp.json();
                if (!resp.ok || !data.ok) throw new Error(data.error || 'Falha ao excluir');
                closeModal();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Erro ao excluir publicações.');
            }
        });
    };

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
        $('#calendar').php('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
    }
};

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
            defaultDate : moment().format('YYYY-MM-DD'), 
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
        $('#calendar').php('<div class="alert alert-danger">Erro ao carregar o calendário. Recarregue a página.</div>');
    }
};

function setupModalNovaDiscussaoMembro() {
    const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
    const modal = document.getElementById('modalNovaDiscussaoMembro');
    
    if (!btnNovaDiscussao || !modal) {
        console.error('Elementos do modal de membros não encontrados!');
        return;
    }
    
    const closeModal = () => {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    };
    
    const openModal = () => {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };
    
    btnNovaDiscussao.addEventListener('click', function(e) {
        e.preventDefault();
        openModal();
    });
    
    modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-button')?.addEventListener('click', closeModal);
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    
    const form = document.getElementById('formNovaDiscussaoMembro');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const titulo = document.getElementById('tituloDiscussaoMembro').value;
            const mensagem = document.getElementById('mensagemDiscussaoMembro').value;
            
            if (!titulo) {
                alert('Por favor, insira um título para a discussão');
                return;
            }
            
            alert(`Discussão "${titulo}" criada com sucesso! (Simulação)`);
            closeModal();
            form.reset();
        });
    }
}

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

    function isAdmin() {
        return window.location.pathname.includes('-admin.php');
    }

    function carregarDiscussoes() {
        const container = document.getElementById('discussoes-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        forumData.discussoes.forEach(discussao => {
            const discussaoHTML = `
                <div class="discussao-card" data-id="${discussao.id}">
                    <div class="discussao-info">
                        <h4>${discussao.titulo}</h4>
                        <div class="discussao-meta">
                            <span><i class="fas fa-user"></i> ${discussao.criador}</span>
                            <span><i class="fas fa-calendar-alt"></i> ${discussao.data}</span>
                            <span><i class="fas fa-comment"></i> ${discussao.mensagens} mensagens</span>
                        </div>
                    </div>
                    <div class="discussao-acoes">
                        <a href="${isAdmin() ? 'discussao-ex-admin.php' : 'discussao-membros-ex.php'}?id=${discussao.id}" class="btn-acessar">
                            <i class="fas fa-comments"></i> Acessar
                        </a>
                        ${isAdmin() ? `
                        <button class="btn-excluir-discussao" data-id="${discussao.id}">
                            <i class="fas fa-trash"></i> Excluir
                        </button>` : ''}
                    </div>
                </div>
            `;
            container.innerHTML += discussaoHTML;
        });

        if (isAdmin()) {
            document.querySelector('.btn-nova-discussao')?.addEventListener('click', function(e) {
                e.preventDefault();
                abrirModalNovaDiscussao();
            });

            document.querySelectorAll('.btn-excluir-discussao').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const discussaoId = this.getAttribute('data-id');
                    abrirModalExclusaoDiscussao(discussaoId);
                });
            });
        }
    }

    function abrirModalNovaDiscussao() {
        const modal = document.getElementById('modalNovaDiscussao');
        if (!modal) return;

        const listaMembros = document.getElementById('listaMembros');
        if (listaMembros) {
            listaMembros.innerHTML = '';
            
            forumData.membros.forEach(membro => {
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
        }
        
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function fecharModalNovaDiscussao() {
        const modal = document.getElementById('modalNovaDiscussao');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    let discussaoIdParaExcluir = null;

    function abrirModalExclusaoDiscussao(id) {
        discussaoIdParaExcluir = id;
        const modal = document.getElementById('modalExcluirDiscussao');
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function fecharModalExclusaoDiscussao() {
        const modal = document.getElementById('modalExcluirDiscussao');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function setupForumModals() {
        document.querySelector('#modalNovaDiscussao .modal-close')?.addEventListener('click', fecharModalNovaDiscussao);
        document.querySelector('#modalNovaDiscussao .cancel-button')?.addEventListener('click', fecharModalNovaDiscussao);
        document.getElementById('cancelarExclusaoDiscussao')?.addEventListener('click', fecharModalExclusaoDiscussao);
        document.getElementById('modalNovaDiscussao')?.addEventListener('click', (e) => {
            if (e.target === document.getElementById('modalNovaDiscussao')) {
                fecharModalNovaDiscussao();
            }
        });
        
        document.getElementById('modalExcluirDiscussao')?.addEventListener('click', (e) => {
            if (e.target === document.getElementById('modalExcluirDiscussao')) {
                fecharModalExclusaoDiscussao();
            }
        });
        
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
            
            const novaDiscussao = {
                id: forumData.discussoes.length + 1,
                titulo: titulo,
                criador: "Fernanda Sehn",
                data: new Date().toLocaleDateString('pt-BR'),
                mensagens: 0,
                membrosComAcesso: membrosSelecionados.length > 0 ? membrosSelecionados : ["all"]
            };
            
            forumData.discussoes.push(novaDiscussao);
            
            alert('Discussão criada com sucesso!');
            fecharModalNovaDiscussao();
            this.reset();
            carregarDiscussoes();
        });
        
        document.getElementById('confirmarExclusaoDiscussao')?.addEventListener('click', () => {
            if (discussaoIdParaExcluir) {
                const index = forumData.discussoes.findIndex(d => d.id == discussaoIdParaExcluir);
                if (index !== -1) {
                    forumData.discussoes.splice(index, 1);
                }
                alert('Discussão excluída com sucesso!');
                carregarDiscussoes();
            }
            fecharModalExclusaoDiscussao();
        });
    }

    function setupModalNovaDiscussaoMembro() {
        const btnNovaDiscussao = document.querySelector('.btn-nova-discussao');
        const modal = document.getElementById('modalNovaDiscussaoMembro');
        
        if (!btnNovaDiscussao || !modal) {
            console.error('Elementos do modal de membros não encontrados!');
            return;
        }
        
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };
        
        const openModal = () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        
        btnNovaDiscussao.addEventListener('click', function(e) {
            e.preventDefault();
            openModal();
        });
        
        modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
        modal.querySelector('.cancel-button')?.addEventListener('click', closeModal);
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });
        
        const form = document.getElementById('formNovaDiscussaoMembro');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const titulo = document.getElementById('tituloDiscussaoMembro').value;
                const mensagem = document.getElementById('mensagemDiscussaoMembro').value;
                
                if (!titulo) {
                    alert('Por favor, insira um título para a discussão');
                    return;
                }
                
                const novaDiscussao = {
                    id: forumData.discussoes.length + 1,
                    titulo: titulo,
                    criador: "Você",
                    data: new Date().toLocaleDateString('pt-BR'),
                    mensagens: 0,
                    membrosComAcesso: ["all"]
                };
                
                forumData.discussoes.push(novaDiscussao);
                
                alert('Discussão criada com sucesso!');
                closeModal();
                form.reset();
                
                if (isAdmin()) {
                    carregarDiscussoesAdmin();
                } else {
                    carregarDiscussoesMembro();
                }
            });
        }
    }

    function carregarDiscussoesMembro() {
        const container = document.getElementById('discussoes-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        forumData.discussoes.forEach(discussao => {
            const discussaoHTML = `
                <div class="discussao-card" data-id="${discussao.id}">
                    <div class="discussao-info">
                        <h4>${discussao.titulo}</h4>
                        <div class="discussao-meta">
                            <span><i class="fas fa-user"></i> ${discussao.criador}</span>
                            <span><i class="fas fa-calendar-alt"></i> ${discussao.data}</span>
                            <span><i class="fas fa-comment"></i> ${discussao.mensagens} mensagens</span>
                        </div>
                    </div>
                    <div class="discussao-acoes">
                        <a href="discussao-membros-ex.php?id=${discussao.id}" class="btn-acessar">
                            <i class="fas fa-comments"></i> Acessar
                        </a>
                    </div>
                </div>
            `;
            container.innerHTML += discussaoHTML;
        });
    }

    function carregarDiscussoesAdmin() {
        const container = document.getElementById('discussoes-container');
        if (!container) return;
        
        container.innerHTML = '';
        
        forumData.discussoes.forEach(discussao => {
            const discussaoHTML = `
                <div class="discussao-card" data-id="${discussao.id}">
                    <div class="discussao-info">
                        <h4>${discussao.titulo}</h4>
                        <div class="discussao-meta">
                            <span><i class="fas fa-user"></i> ${discussao.criador}</span>
                            <span><i class="fas fa-calendar-alt"></i> ${discussao.data}</span>
                            <span><i class="fas fa-comment"></i> ${discussao.mensagens} mensagens</span>
                        </div>
                    </div>
                    <div class="discussao-acoes">
                        <a href="discussao-ex-admin.php?id=${discussao.id}" class="btn-acessar">
                            <i class="fas fa-comments"></i> Acessar
                        </a>
                        <button class="btn-excluir-discussao" data-id="${discussao.id}">
                            <i class="fas fa-trash"></i> Excluir
                        </button>
                    </div>
                </div>
            `;
            container.innerHTML += discussaoHTML;
        });

        document.querySelectorAll('.btn-excluir-discussao').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const discussaoId = this.getAttribute('data-id');
                abrirModalExclusaoDiscussao(discussaoId);
            });
        });
    }

    if (document.querySelector('.forum-container') || window.location.pathname.includes('forum')) {
        carregarDiscussoes();
        setupForumModals();
        
        if (isAdmin()) {
            document.querySelector('.btn-nova-discussao')?.addEventListener('click', function(e) {
                e.preventDefault();
                abrirModalNovaDiscussao();
            });
        }
    }

    function setupChat() {
        const btnEnviar = document.querySelector('.btn-enviar');
        const chatInput = document.querySelector('.chat-input textarea');
        const chatMessages = document.querySelector('.chat-messages');
        const replyContainer = document.querySelector('.reply-container');
        const cancelReplyBtn = document.querySelector('.cancel-reply');
        let replyingTo = null;

        const isAdmin = window.location.pathname.includes('-admin.php');
        const currentUser = isAdmin ? {
            name: "Fernanda Sehn",
            role: "bolsista",
            avatar: "../imagens/computer.jpg"
        } : {
            name: "Dr. Daniel Santana",
            role: "vice-coordenador",
            avatar: "../imagens/estrela.jpg"
        };

        function setupMessageActions() {
            document.querySelectorAll('.reply-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const message = this.closest('.message');
                    const sender = message.querySelector('.message-sender').textContent;
                    const text = message.querySelector('.message-text').textContent;
                    
                    replyingTo = {
                        sender: sender,
                        text: text,
                        messageElement: message
                    };
                    
                    replyContainer.style.display = 'block';
                    replyContainer.querySelector('.reply-text').textContent = `${sender}: ${text}`;
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const message = this.closest('.message');
                    
                    if (confirm('Tem certeza que deseja excluir esta mensagem?')) {
                        message.style.opacity = '0.5';
                        message.style.pointerEvents = 'none';
                        alert('Mensagem excluída com sucesso!');
                    }
                });
            });

            document.querySelectorAll('.admin-dropdown').forEach(dropdown => {
                const btn = dropdown.querySelector('.admin-btn');
                const content = dropdown.querySelector('.admin-dropdown-content');
                
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    document.querySelectorAll('.admin-dropdown-content').forEach(d => {
                        if (d !== content) d.style.display = 'none';
                    });
                    content.style.display = content.style.display === 'block' ? 'none' : 'block';
                });

                const replyBtn = dropdown.querySelector('.reply-message-btn');
                if (replyBtn) {
                    replyBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const message = this.closest('.message');
                        const sender = message.querySelector('.message-sender').textContent;
                        const text = message.querySelector('.message-text').textContent;
                        
                        replyingTo = {
                            sender: sender,
                            text: text,
                            messageElement: message
                        };
                        
                        replyContainer.style.display = 'block';
                        replyContainer.querySelector('.reply-text').textContent = `${sender}: ${text}`;
                        
                        content.style.display = 'none';
                    });
                }

                const deleteBtn = dropdown.querySelector('.delete-message-btn');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const message = this.closest('.message');
                        if (confirm('Simulação: Apagar esta mensagem?')) {
                            message.style.opacity = '0.5';
                            message.style.backgroundColor = '#ffecec';
                            alert('Simulação: Mensagem marcada para exclusão!');
                        }
                        content.style.display = 'none';
                    });
                }
            });

            document.addEventListener('click', function() {
                document.querySelectorAll('.admin-dropdown-content').forEach(content => {
                    content.style.display = 'none';
                });
            });
        }

        if (cancelReplyBtn) {
            cancelReplyBtn.addEventListener('click', function() {
                replyContainer.style.display = 'none';
                replyingTo = null;
            });
        }

        if (btnEnviar && chatInput) {
            btnEnviar.addEventListener('click', function() {
                const messageText = chatInput.value.trim();
                if (messageText) {
                    const newMessage = document.createElement('div');
                    newMessage.className = 'message message-self';
                    
                    let replyHtml = '';
                    if (replyingTo) {
                        replyHtml = `<div class="message-reply">
                            <span class="reply-label">Respondendo a ${replyingTo.sender}</span>
                            <span class="reply-content">${replyingTo.text}</span>
                        </div>`;
                        
                        replyContainer.style.display = 'none';
                        replyingTo = null;
                    }
                    
                    newMessage.innerHTML = `
                        <div class="message-header">
                            <img src="${currentUser.avatar}" alt="${currentUser.name}" class="message-avatar">
                            <div class="message-sender ${currentUser.role}">Você</div>
                            <div class="message-actions">
                                <button class="reply-btn" title="Responder"><i class="fas fa-reply"></i></button>
                                <button class="delete-btn" title="Excluir"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        ${replyHtml}
                        <div class="message-text">${messageText}</div>
                        <div class="message-time">${new Date().toLocaleString('pt-BR')}</div>
                    `;
                    
                    chatMessages.appendChild(newMessage);
                    chatInput.value = '';
                    newMessage.scrollIntoView({ behavior: 'smooth' });
                    setupMessageActions();
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
        
        setupMessageActions();
    }

const setupBiografiaPage = () => {
    const editButton = document.querySelector('.edit-button');
    const biographyText = document.querySelector('.biography-text');
    
    const changePhotoButton = document.querySelector('.change-photo-button');
    const profileImage = document.querySelector('.profile-image');
    
    if (editButton && biographyText) {
        editButton.addEventListener('click', async () => {
            const isEditing = biographyText.hasAttribute('contenteditable');
            if (isEditing) {
                // Salvar de verdade
                const idInput = document.querySelector('#formEditarContato input[name="id_usuario"], #formEditarFoto input[name="id_usuario"]');
                const idUsuario = idInput?.value;
                const plainText = biographyText.innerText.trim();
                try {
                    const resp = await fetch('../include/atualizar_biografia.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `id_usuario=${encodeURIComponent(idUsuario || '')}&bio=${encodeURIComponent(plainText)}`
                    });
                    const data = await resp.json();
                    if (!resp.ok || !data.ok) throw new Error(data.msg || 'Erro ao salvar biografia');
                    // Modo visual volta ao normal
                    biographyText.removeAttribute('contenteditable');
                    editButton.innerHTML = '<i class="ti-pencil"></i> Editar biografia';
                    biographyText.style.padding = '';
                    biographyText.style.border = '';
                    biographyText.style.borderRadius = '';
                    biographyText.style.minHeight = '';
                } catch (err) {
                    alert(err.message || 'Erro ao salvar biografia');
                }
            } else {
                biographyText.setAttribute('contenteditable', 'true');
                biographyText.focus();
                editButton.innerHTML = '<i class="ti-check"></i> Salvar';
                biographyText.style.padding = '10px';
                biographyText.style.border = '1px dashed #ccc';
                biographyText.style.borderRadius = '4px';
                biographyText.style.minHeight = '100px';
            }
        });
    }
    
    // Se a página tiver modal de foto, evitamos a simulação aqui
    if (changePhotoButton && profileImage && !document.getElementById('modalFoto')) {
        changePhotoButton.addEventListener('click', () => {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = 'image/*';
            
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = (event) => {
                        profileImage.src = event.target.result;
                        alert('Foto de perfil atualizada com sucesso! (Simulação)');
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
            
            fileInput.click();
        });
    }
};

// Modais e submits reais da página de perfil (foto e contatos)
function setupPerfilModals() {
    const modalFoto = document.getElementById('modalFoto');
    const modalContato = document.getElementById('modalContato');
    const btnFoto = document.querySelector('.change-photo-button');
    const btnContatos = document.querySelector('.edit-contacts-button');

    const open = (modal) => { if (modal) { modal.classList.add('active'); document.body.style.overflow = 'hidden'; } };
    const close = (modal) => { if (modal) { modal.classList.remove('active'); document.body.style.overflow = ''; } };

    // Foto
    btnFoto?.addEventListener('click', (e) => { e.preventDefault(); open(modalFoto); });
    modalFoto?.querySelector('.modal-close')?.addEventListener('click', () => close(modalFoto));
    modalFoto?.querySelector('.close-modal')?.addEventListener('click', () => close(modalFoto));
    modalFoto?.addEventListener('click', (e) => { if (e.target === modalFoto) close(modalFoto); });

    // Contatos
    btnContatos?.addEventListener('click', (e) => { e.preventDefault(); open(modalContato); });
    modalContato?.querySelector('.modal-close')?.addEventListener('click', () => close(modalContato));
    modalContato?.querySelector('.close-modal')?.addEventListener('click', () => close(modalContato));
    modalContato?.addEventListener('click', (e) => { if (e.target === modalContato) close(modalContato); });

    // Submit contatos
    document.getElementById('salvarContato')?.addEventListener('click', async () => {
        const form = document.getElementById('formEditarContato');
        if (!form) return;
        const fd = new FormData(form);
        try {
            const resp = await fetch('../include/atualizar_contato.php', { method: 'POST', body: fd });
            const data = await resp.json();
            if (!resp.ok || !data.ok) throw new Error(data.msg || 'Erro ao salvar');

            // Atualiza DOM
            const email = data.email || '';
            const lattes = data.lattes || '';
            const contacts = document.querySelector('.member-contacts');
            const editBtn = document.querySelector('.edit-contacts-button');

            let emailLink = document.querySelector('.email-link');
            if (emailLink) {
                emailLink.setAttribute('href', 'mailto:' + email);
                // texto após o ícone
                const textNode = Array.from(emailLink.childNodes).find(n => n.nodeType === Node.TEXT_NODE);
                if (textNode) textNode.nodeValue = ' ' + email; else emailLink.appendChild(document.createTextNode(' ' + email));
            } else if (email && contacts && editBtn) {
                const a = document.createElement('a');
                a.className = 'email-link';
                a.href = 'mailto:' + email;
                a.innerHTML = '<img src="../imagens/email-icon.png" alt="Email" class="contact-icon"> ' + email;
                contacts.insertBefore(a, editBtn);
            }

            let lattesLink = document.querySelector('.lattes-link');
            if (lattesLink) {
                if (lattes) { lattesLink.setAttribute('href', lattes); }
                else { lattesLink.remove(); }
            } else if (lattes && contacts && editBtn) {
                const a = document.createElement('a');
                a.className = 'lattes-link';
                a.href = lattes; a.target = '_blank';
                a.innerHTML = '<img src="../imagens/lattes-icon.png" alt="Currículo Lattes" class="contact-icon"> Currículo Lattes';
                contacts.insertBefore(a, editBtn);
            }

            close(modalContato);
        } catch (err) {
            alert(err.message || 'Erro ao salvar');
        }
    });

    // Submit foto
    document.getElementById('salvarFoto')?.addEventListener('click', async () => {
        const form = document.getElementById('formEditarFoto');
        if (!form) return;
        const fd = new FormData(form);
        try {
            const resp = await fetch('../include/atualizar_foto.php', { method: 'POST', body: fd });
            const data = await resp.json();
            if (!resp.ok || !data.ok) throw new Error(data.msg || 'Erro ao salvar');
            const img = document.querySelector('.profile-image');
            if (img && data.foto) { img.setAttribute('src', data.foto + '?t=' + Date.now()); }
            // Atualiza avatar da navbar
            document.querySelectorAll('.profile-img').forEach(el => {
                const base = data.foto || el.getAttribute('src');
                el.setAttribute('src', base + '?t=' + Date.now());
            });
            close(modalFoto);
        } catch (err) {
            alert(err.message || 'Erro ao salvar');
        }
    });
}

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

    function setupAdminButtons() {
        document.querySelectorAll('.delete-message-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const message = this.closest('.message');
                if (message) {
                    if (confirm('Simulação: Apagar esta mensagem?')) {
                        message.style.opacity = '0.5';
                        message.style.backgroundColor = '#ffecec';
                        alert('Simulação: Mensagem marcada para exclusão!');
                    }
                }
            });
        });
    }

const setupExclusaoArquivoModal = () => {
    const deleteButton = document.getElementById('openDeleteModal');
    const modalExcluirOverlay = document.getElementById('modalExcluirMembro');
    
    if (!deleteButton || !modalExcluirOverlay) return;

    deleteButton.addEventListener('click', (e) => {
        e.preventDefault();
        
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Por favor, selecione pelo menos um arquivo para excluir.');
            return;
        }
        
        document.body.classList.add('modal-open');
        modalExcluirOverlay.classList.add('active');
        document.body.style.overflow = ('hidden');
    });

    document.getElementById('cancelarExclusao')?.addEventListener('click', () => {
        document.body.classList.remove('modal-open');
        modalExcluirOverlay.classList.remove('active');
        document.body.style.overflow = '';
    });

    document.getElementById('confirmarExclusao')?.addEventListener('click', async () => {
        const checkboxes = document.querySelectorAll('.file-checkbox:checked');
        if (checkboxes.length === 0) return;
        const ids = Array.from(checkboxes).map(cb => parseInt(cb.value, 10)).filter(Number.isFinite);
        try {
            const resp = await fetch('./api/arquivos_excluir.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids })
            });
            const data = await resp.json().catch(() => ({ ok: false, error: 'Falha ao interpretar resposta' }));
            if (!resp.ok || !data.ok) throw new Error(data.error || 'Erro ao excluir arquivos');
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            window.location.reload();
        } catch (err) {
            console.error(err);
            alert('Erro: ' + (err && err.message ? err.message : 'Não foi possível excluir.'));
        }
    });

    modalExcluirOverlay.addEventListener('click', (e) => {
        if (e.target === modalExcluirOverlay) {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
};

    const setupNovaAcaoModal = () => {
        const btnAdicionar = document.querySelector('.btn-adicionar');
        const modalAcao = document.getElementById('modalNovaAcao');
        
        if (!btnAdicionar || !modalAcao) return;

        const closeModal = () => {
            modalAcao.classList.remove('active');
            document.body.style.overflow = '';
        };

        const openModal = () => {
            const dataAtual = new Date();
            const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
            document.getElementById('dataAtualAcao').textContent = dataAtual.toLocaleDateString('pt-BR', options);
            
            modalAcao.classList.add('active');
            document.body.style.overflow = 'hidden';
        };

        btnAdicionar.addEventListener('click', openModal);

        document.querySelectorAll('.modal-acao-close, .modal-acao-cancel').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        modalAcao.addEventListener('click', (e) => {
            if (e.target === modalAcao) closeModal();
        });

        document.getElementById('formAcao')?.addEventListener('submit', (e) => {
            e.preventDefault();
            const titulo = document.getElementById('tituloAcao').value;
            const descricao = document.getElementById('descricaoAcao').value;
            const imagem = document.getElementById('imagemAcao').files[0];
            
            console.log('Nova ação:', { titulo, descricao, imagem });
            alert('Ação criada com sucesso!');
            
            e.target.reset();
            closeModal();
        });

        document.getElementById('imagemAcao')?.addEventListener('change', function() {
            const label = this.nextElementSibling;
            if (this.files.length > 0) {
                label.textContent = this.files[0].name;
            } else {
                label.innerHTML = '<i class="ti-image mr-2"></i>Selecione uma imagem';
            }
        });
    };

    const setupExclusaoAcaoModal = () => {
        const deleteButton = document.querySelector('.btn-excluir');
        const modalExcluirOverlay = document.getElementById('modalExcluirAcao');
        
        if (!deleteButton || !modalExcluirOverlay) {
            console.error('Elementos do modal de exclusão de ações não encontrados!');
            return;
        }

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            
            document.querySelectorAll('.publi-checkbox:checked').forEach(checkbox => {
                checkbox.checked = false;
            });
        };

        const openModal = () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Por favor, selecione pelo menos uma ação para excluir.');
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

        document.getElementById('cancelarExclusaoAcao')?.addEventListener('click', closeModal);

        modalExcluirOverlay.addEventListener('click', (e) => {
            if (e.target === modalExcluirOverlay) closeModal();
        });

        document.getElementById('confirmarExclusaoAcao')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            alert(`Simulação: ${checkboxes.length} ação(ões) marcada(s) para exclusão!`);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            closeModal();
        });
    };

    // === Eventos (CRUD real, usando tabela evento) ===
    const setupEventoModal = () => {
        const btnAdicionar = document.querySelector('.btn-adicionar');
        const modalEvento = document.getElementById('modalEvento');
        if (!btnAdicionar || !modalEvento) return;

        const closeModal = () => {
            modalEvento.classList.remove('active');
            document.body.style.overflow = '';
        };
        const openModal = () => {
            const span = document.getElementById('dataAtualEvento');
            if (span) {
                const now = new Date();
                span.textContent = now.toLocaleDateString('pt-BR') + ' ' + now.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
            }
            modalEvento.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        btnAdicionar.addEventListener('click', openModal);

        document.querySelectorAll('.modal-publicacao-close, .modal-publicacao-cancel').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });
        modalEvento.addEventListener('click', (e) => { if (e.target === modalEvento) closeModal(); });

        document.getElementById('formEvento')?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const titulo = document.getElementById('tituloEvento')?.value?.trim();
            if (!titulo) { alert('Informe um título.'); return; }
            const fd = new FormData(form);
            try {
                const resp = await fetch('./api/eventos_criar.php', { method: 'POST', body: fd, headers: { 'Accept': 'application/json' } });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao criar evento');
                form.reset();
                closeModal();
                window.location.href = data.redirect;
            } catch (err) {
                console.error(err);
                alert('Erro ao criar evento.');
            }
        });
    };

    const setupExclusaoEventoModal = () => {
        const deleteButton = document.querySelector('.btn-excluir');
        const modalExcluirOverlay = document.getElementById('modalExcluirEvento');
        if (!deleteButton || !modalExcluirOverlay) return;

        const closeModal = () => {
            document.body.classList.remove('modal-open');
            modalExcluirOverlay.classList.remove('active');
            document.body.style.overflow = '';
            document.querySelectorAll('.publi-checkbox:checked').forEach(cb => { cb.checked = false; });
        };
        const openModal = () => {
            const checkboxes = document.querySelectorAll('.publi-checkbox:checked');
            if (checkboxes.length === 0) { alert('Selecione ao menos um evento para excluir.'); return; }
            document.body.classList.add('modal-open');
            modalExcluirOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        };
        deleteButton.addEventListener('click', (e) => { e.preventDefault(); openModal(); });
        document.getElementById('cancelarExclusaoEvento')?.addEventListener('click', closeModal);
        modalExcluirOverlay.addEventListener('click', (e) => { if (e.target === modalExcluirOverlay) closeModal(); });
        document.getElementById('confirmarExclusaoEvento')?.addEventListener('click', async () => {
            const ids = Array.from(document.querySelectorAll('.publi-checkbox:checked')).map(cb => parseInt(cb.value, 10)).filter(Boolean);
            if (!ids.length) { closeModal(); return; }
            try {
                const resp = await fetch('./api/eventos_excluir.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ids }) });
                const data = await resp.json();
                if (!resp.ok || !data?.ok) throw new Error(data?.error || 'Falha ao excluir evento');
                closeModal();
                window.location.reload();
            } catch (err) {
                console.error(err);
                alert('Erro ao excluir eventos.');
            }
        });
    };

    setupPostCarousel();

    if (document.getElementById('calendar')) {
        if (document.querySelector('.btn-adicionar')) {
            setupAgendaAdmin();
        } else {
            setupAgendaMembro();
        }
    }

    if (document.getElementById('modalNovaDiscussaoMembro')) {
    setupModalNovaDiscussaoMembro();
}

    if (document.querySelector('.btn-adicionar')) setupPublicacaoModal();
    if (document.querySelector('.add-member-button')) setupCadastroModal();
    if (document.querySelector('.delete-member-button')) setupExclusaoModal();
    if (document.querySelector('.btn-excluir')) setupExclusaoPublicacaoModal();
    if (document.getElementById('supportForm')) setupSupportModal();
    if (document.querySelector('.add-file-button')) setupUploadModal();
    if (document.querySelector('.forgot-password')) setupEsqueceuSenhaModal();
    // Executa edição de biografia apenas em páginas de biografia
    if (document.querySelector('.biography-container') && document.querySelector('.edit-text')) setupBiografiaEdicao();
    if (document.getElementById('openDeleteModal')) setupExclusaoArquivoModal();
    if (document.querySelector('.biography-container')) setupBiografiaPage();
    if (document.getElementById('modalFoto') || document.getElementById('modalContato')) setupPerfilModals();

    if (window.location.pathname.includes('eventos-admin.php')) {
        setupEventoModal();
        setupExclusaoEventoModal();
    }

    // Edição da página Sobre (admin)
    function setupEditarSobre() {
        const editBtn = document.querySelector('.edit-text');
        const container = document.getElementById('sobreTexto');
        const buttons = document.getElementById('sobreEditButtons');
        if (!editBtn || !container || !buttons) return;

        let originalHTML = '';

        const startEdit = () => {
            originalHTML = container.innerHTML;
            container.setAttribute('contenteditable', 'true');
            container.classList.add('editing');
            buttons.style.display = 'flex';
            editBtn.setAttribute('disabled', 'disabled');
            editBtn.classList.remove('btn-primary');
            editBtn.classList.add('btn-secondary');
            editBtn.textContent = 'Modificando texto';
        };

        const cancelEdit = () => {
            container.innerHTML = originalHTML;
            container.removeAttribute('contenteditable');
            container.classList.remove('editing');
            buttons.style.display = 'none';
            editBtn.removeAttribute('disabled');
            editBtn.classList.remove('btn-secondary');
            editBtn.classList.add('btn-primary');
            editBtn.innerHTML = '<i class="ti-pencil mr-2"></i>Modificar Texto';
        };

        const saveEdit = async () => {
            // remove atributos contenteditable e quaisquer elementos de edição acidentais
            const tmp = document.createElement('div');
            tmp.innerHTML = container.innerHTML;
            tmp.querySelectorAll('[contenteditable]')?.forEach(el => el.removeAttribute('contenteditable'));
            tmp.querySelectorAll('.edit-buttons')?.forEach(el => el.remove());
            const html = tmp.innerHTML;
            try {
                const resp = await fetch('../include/atualizar_sobre.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                    body: 'html=' + encodeURIComponent(html)
                });
                const data = await resp.json().catch(() => ({}));
                if (!resp.ok || !data.success) throw new Error(data.error || 'Falha ao salvar');
                container.removeAttribute('contenteditable');
                container.classList.remove('editing');
                buttons.style.display = 'none';
                editBtn.removeAttribute('disabled');
                editBtn.classList.remove('btn-secondary');
                editBtn.classList.add('btn-primary');
                editBtn.innerHTML = '<i class="ti-pencil mr-2"></i>Modificar Texto';
            } catch (err) {
                alert(err.message || 'Erro ao salvar');
            }
        };

        editBtn.addEventListener('click', (e) => { e.preventDefault(); startEdit(); });
        buttons.querySelector('.btn-cancelar')?.addEventListener('click', (e) => { e.preventDefault(); cancelEdit(); });
        buttons.querySelector('.btn-salvar')?.addEventListener('click', (e) => { e.preventDefault(); saveEdit(); });
    }

    if (window.location.pathname.includes('sobre-admin.php')) {
        setupEditarSobre();
    }

    setupAdminButtons();

});

document.addEventListener("DOMContentLoaded", setupPostCarousel);


/* Profile dropdown toggle and logout (kept in central script file) */
(function() {
    function initProfileDropdown() {
        // One delegated click handler to manage open/close and clicks
        document.addEventListener('click', function(e) {
            // Prefer explicit simple selectors so closest() works reliably
            const clickedWrapper = e.target.closest('.profile-dropdown-wrapper');
            const clickedToggle = e.target.closest('.dropdown-toggle');
            const clickedMenu = e.target.closest('.profile-dropdown-menu');

            // If user clicked a toggle that's inside a profile wrapper -> toggle that menu
            if (clickedToggle && clickedWrapper && clickedWrapper.contains(clickedToggle)) {
                const menu = clickedWrapper.querySelector('.profile-dropdown-menu');
                if (!menu) return;
                // close other open menus first
                document.querySelectorAll('.profile-dropdown-menu.show').forEach(m => {
                    if (m !== menu) m.classList.remove('show');
                });
                menu.classList.toggle('show');
                e.preventDefault();
                return;
            }

            // If clicked inside an open menu, allow link clicks to proceed
            if (clickedMenu) return;

            // Click outside dropdowns -> close any open menus
            document.querySelectorAll('.profile-dropdown-menu.show').forEach(m => m.classList.remove('show'));
        });

        // Delegated logout handler (works even if element is rendered later)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('#logout-btn');
            if (!btn) return;
            e.preventDefault();
            if (confirm('Deseja realmente sair da sua conta?')) {
                // server-side logout that destroys session and redirects
                window.location.href = '../anonimo/logout.php';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProfileDropdown);
    } else {
        initProfileDropdown();
    }
})();