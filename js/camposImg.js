function adicionarImagem() {
    const containerImagens = document.getElementById('containerImagens');
    const novoDiv = document.createElement('div');
    novoDiv.className = 'imagem-input';

    const novoInputURL = document.createElement('input');
    novoInputURL.type = "text";
    novoInputURL.name = 'imagem_url[]';
    novoInputURL.placeholder = 'URL da imagem';
    novoInputURL.required = true;

    const novoInputOrdem = document.createElement('input');
    novoInputOrdem.type = "number";
    novoInputOrdem.name = 'imagem_ordem[]';
    novoInputOrdem.placeholder = 'Ordem';
    novoInputOrdem.min = '1'
    novoInputOrdem.required = true;


    novoDiv.appendChild(novoInputURL);
    novoDiv.appendChild(novoInputOrdem);

    containerImagens.appendChild(novoDiv);
}
