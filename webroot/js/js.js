$(window).load(function(){

    // READ URL FOR PREVIEW IMAGE ADD POST AND UPDATE POST AND CHECK ERRORS
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                if ($('.image').length) {
                    $('<div class="cropped strechy-wrapper"></div>').insertAfter('.image');
                    $('.image').remove();
                }

                var filename = input.files[0].name;
                var extension = filename.replace(/^.*\./, '');
                var size = input.files[0].size;
                //console.log(extension);

                if (size > $("input[name='MAX_FILE_SIZE']").val()) {
                    $('.cropped').css('background-image', 'url()');
                    $('<div class="callout alert erreurImage">Le fichier excède la taille maximum autorisé. (' + Math.floor($("input[name='MAX_FILE_SIZE']").val() / 1000000) + ' Mo)</div>').insertAfter('.cropped');
                } else if (extension == filename) {
                    extension = '';
                } else {
                    extension = extension.toLowerCase();
                }

                switch (extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $('.cropped').css('background-image', 'url(' + e.target.result + ')');
                    break;

                    default:
                        $('.cropped').css('background-image', 'url()');
                        $('<div class="callout alert erreurImage">L\' extension n\'est pas autorisée.</div>').insertAfter('.cropped');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // RUN FUNCTION readURL FOR IMAGE'S PREVIEW AND CHECK ERRORS
    $("#image").change(function () {
        readURL(this);
        $('.erreurImage').remove();
    });

    // CHECK AND REMOVE ERROR => ADD POST
    $("#titre").keydown(function () {
        $('#erreurTitre').remove();
    });

    $("#auteur").keydown(function () {
        $('#erreurAuteur').remove();
    });

    // CHECK AND REMOVE ERROR => ADD COMMENT
    $("#comNom").keydown(function () {
        $('#erreurNom').remove();
    });

    $("#comContenu").keydown(function () {
        $('#erreurContenu').remove();
    });

    $("#envoyer").click(function () {
        valid = true;
        if ($('#comNom').val() === ""){
            $('#erreurNom').remove();
            $('<div class="callout alert" id="erreurNom">Ce champ est requis.</div>').insertAfter('#comNom');
            valid = false;
        }

        if ($('#comContenu').val() === "") {
            $('#erreurContenu').remove();
            $('<div class="callout alert" id="erreurContenu">Ce champ est requis.</div>').insertAfter('#comContenu');
        }
        return valid;
    });

    // CHANGE NAVBAR CLASS WHEN SCROLLED
    $(document).scroll(function () {
        var $nav = $(".navbar-fixed-top");
        $nav.toggleClass('scrolled', $(this).scrollTop() > $('.top-bar').height());
    });

    // Smooth Scroll sur page billet.php
    $('.js-scrollTo').on('click', function() { // Au clic sur un élément
        var page = $(this).attr('href'); // Page cible
        var speed = 750; // Durée de l'animation (en ms)
        $('html, body').animate( { scrollTop: $(page).offset().top }, speed ); // Go
        return false;
    });

    // Ajax signaler un commentaire
    $('.blog-post').on('click', '.hollow', function(e){
        e.preventDefault();
        var $a = $(this);
        $a.text('En cours...');
        var $url = $a.attr('href');
        $.post($url)
            .done(function(){
                $a.parent($('.comment-section-text')).fadeOut('slow', function () {
                    $a.parent($('.comment-section-text')).after('<i class="fa fa-times-circle-o infobulle" aria-hidden="true" aria-label="Commentaire signalé"></i>');
                    $a.parent($('.comment-section-text')).after('<p>Ce commentaire a été signalé comme inapproprié.</p>');
                    $a.parent($('.comment-section-text')).remove();
                    $nbCom = parseInt($('.roundNotification_count').text()) + 1;
                    $('.roundNotification_count').text($nbCom);
                });
            })
    });

    // Ajax envoyer un commentaire
    $('#add-comment').on('submit', function(e){
        e.preventDefault();
        $('#envoyer').prop('value', 'Envoi en cours...');
        var $form = $(this);
        var $url = $form.attr('action');
        $.post($url, $form.serializeArray())
            .done(function(data, text, jqxhr){
                $response = $(jqxhr.responseText);
                $('.h3Com').after($response);
                $response.hide().fadeIn();
                $('#comNom').val('');
                $('#comContenu').val('');
                $('#envoyer').prop('value', 'Envoyer');
            })
    });

    // Ajax supprimer un commentaire
    $('.delete').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var $url = $form.attr('action');
        var $nbCom = parseInt($('.h3Com h3').text()) - 1;
        $.post($url)
            .done(function(){
                $form.parent().parent($('.comment-section-container')).slideUp('slow', function () {
                    $form.parent().parent($('.comment-section-container')).remove();
                    if ($nbCom > 1) {$('.h3Com h3').text($nbCom + ' Commentaires signalés')} else {$('.h3Com h3').text($nbCom + ' Commentaire signalé')}
                    $nbCom = parseInt($('.roundNotification_count').text()) - 1;
                    $('.roundNotification_count').text($nbCom);
                });
            })
    });

    // Ajax modérer un commentaire
    $('.moderate').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var $url = $form.attr('action');
        var $nbCom = parseInt($('.h3Com h3').text()) -1 ;
        $.post($url, $form.serializeArray())
            .done(function(data, text, jqxhr){
                $form.parent().parent($('.comment-section-container')).slideUp('slow', function () {
                    $form.parent().parent($('.comment-section-container')).remove();
                    if ($nbCom > 1) {$('.h3Com h3').text($nbCom + ' Commentaires signalés')} else {$('.h3Com h3').text($nbCom + ' Commentaire signalé')}
                    $nbCom = parseInt($('.roundNotification_count').text()) - 1;
                    $('.roundNotification_count').text($nbCom);
                    console.log(data);
                });
            })
    });

});