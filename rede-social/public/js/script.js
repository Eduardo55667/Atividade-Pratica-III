// public/js/script.js

function rota(caminho) {
    const baseUrl = window.BASE_URL || '';
    return baseUrl + '/' + caminho.replace(/^\/+/, '');
}

function enviarPost(caminho, dados) {
    return fetch(rota(caminho), {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(dados).toString()
    }).then(response => {
        if (!response.ok) {
            throw new Error('Erro HTTP ' + response.status);
        }

        return response.text();
    });
}

// 1. FUNÇÃO PARA CURTIR POST (AJAX)
function curtirPost(postId, botao) {
    const contadorSpan = botao.querySelector('.contador');
    const numeroAtual = parseInt(contadorSpan.innerText, 10) || 0;
    const icone = botao.querySelector('i');

    botao.disabled = true;

    enviarPost('/curtir', { post_id: postId })
    .then(status => {
        if (status.trim() === 'adicionado') {
            icone.classList.replace('bi-heart', 'bi-heart-fill');
            icone.classList.add('text-danger');
            contadorSpan.innerText = numeroAtual + 1;
        } else if (status.trim() === 'removido') {
            icone.classList.replace('bi-heart-fill', 'bi-heart');
            icone.classList.remove('text-danger');
            contadorSpan.innerText = Math.max(0, numeroAtual - 1);
        }
    })
    .catch(error => {
        console.error('Nao foi possivel curtir o post:', error);
    })
    .finally(() => {
        botao.disabled = false;
    });
}

// 2. FUNÇÃO PARA SEGUIR USUÁRIO NA TELA DE BUSCA (AJAX)
function seguirUsuario(alvoId, botao) {
    botao.disabled = true;

    enviarPost('/seguir', { alvo_id: alvoId })
    .then(status => {
        if (status.trim() === 'adicionado') {
            botao.classList.replace('btn-primary', 'btn-secondary');
            botao.innerText = 'Deixar de Seguir';
        } else if (status.trim() === 'removido') {
            botao.classList.replace('btn-secondary', 'btn-primary');
            botao.innerText = 'Seguir';
        }
    })
    .catch(error => {
        console.error('Nao foi possivel seguir o usuario:', error);
    })
    .finally(() => {
        botao.disabled = false;
    });
}

// 3. FUNÇÃO PARA SEGUIR USUÁRIO NA TELA DE PERFIL DELE (AJAX)
function seguirUsuarioPerfil(alvoId, botao) {
    const contador = document.getElementById('cont-seguidores');
    const numeroAtual = contador ? (parseInt(contador.innerText, 10) || 0) : 0;

    botao.disabled = true;

    enviarPost('/seguir', { alvo_id: alvoId })
    .then(status => {
        if (status.trim() === 'adicionado') {
            botao.classList.replace('btn-primary', 'btn-secondary');
            botao.innerText = 'Deixar de Seguir';
            if (contador) contador.innerText = numeroAtual + 1;
        } else if (status.trim() === 'removido') {
            botao.classList.replace('btn-secondary', 'btn-primary');
            botao.innerText = 'Seguir';
            if (contador) contador.innerText = Math.max(0, numeroAtual - 1);
        }
    })
    .catch(error => {
        console.error('Nao foi possivel seguir o usuario:', error);
    })
    .finally(() => {
        botao.disabled = false;
    });
}

// 4. CONTROLE DO MODO ESCURO E INTERAÇÕES DE TELA
document.addEventListener("DOMContentLoaded", function () {
    const btnModo = document.getElementById("btnModo");
    
    if (btnModo) { 
        btnModo.addEventListener("click", function () {
            document.body.classList.toggle("dark"); 
            
            if (document.body.classList.contains("dark")) {
                btnModo.classList.replace("bi-moon-stars-fill", "bi-sun-fill");
                btnModo.setAttribute("title", "Modo Claro");
            } else {
                btnModo.classList.replace("bi-sun-fill", "bi-moon-stars-fill");
                btnModo.setAttribute("title", "Modo Escuro");
            }
        });
    }
});

// 5. EXIBIR/OCULTAR CAIXA DE COMENTÁRIOS
function toggleComentarios(botao) {
    const postCard = botao.closest('.post');
    if (!postCard) return;

    const container = postCard.querySelector('.comentarios-container');

    if (container) {
        container.classList.toggle('d-none');
    }
}
