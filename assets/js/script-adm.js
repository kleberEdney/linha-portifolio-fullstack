function laPortifolioStakMetaMedias(event) {
    var frame;
    event.preventDefault();
    // Se o frame já existir, abra-o
    if (frame) {
        frame.open();
        return;
    }

    // Crie o media frame
    frame = wp.media({
        title: 'Selecione ou faça upload da imagem',
        button: {
            text: 'Usar essa imagem'
        },
        multiple: false
    });

    // Quando uma imagem for selecionada, execute uma callback
    frame.on('select', function () {
        var attachment = frame.state().get('selection').first().toJSON();
        document.querySelector('#tax-img-input').value = attachment.url;
        document.querySelector('#tax-img').src = attachment.url;
    });

    // Abra o frame
    frame.open();
}
