$(document).ready(function() {
    // Função para ler texto
    function lerTexto(texto) {
        if ('speechSynthesis' in window) {
            const utterance = new SpeechSynthesisUtterance(texto);
            utterance.lang = 'pt-BR';
            window.speechSynthesis.speak(utterance);
        } else {
            alert('Seu navegador não suporta síntese de voz.');
        }
    }

    // Ler título da página ao carregar
    lerTexto(document.title);

    // Ler conteúdo de elementos focados
    $('a, button, input, select, textarea').on('focus', function() {
        const texto = $(this).text() || $(this).attr('aria-label') || $(this).attr('placeholder') || '';
        if (texto) {
            lerTexto(texto);
        }
    });

    // Botão para ler todo o conteúdo principal
    $('#ler-conteudo').on('click', function() {
        const mainContent = $('.content').text().replace(/\s+/g, ' ').trim();
        lerTexto(mainContent);
    });

    // Adiciona rótulos acessíveis para ícones
    $('[aria-hidden="true"]').each(function() {
        const label = $(this).attr('aria-label');
        if (!label) {
            const meaningfulLabel = $(this).data('label') || '';
            if (meaningfulLabel) {
                $(this).attr('aria-hidden', 'false').attr('aria-label', meaningfulLabel);
            }
        }
    });
});