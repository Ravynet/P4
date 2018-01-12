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
                console.log(extension);

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
        $nav.toggleClass('scrolled', $(this).scrollTop() > $('.menu-text').height());
    });

});