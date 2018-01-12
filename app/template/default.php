<!DOCTYPE html>
<html>
    <head>
        <title><?php echo Config::get("site_name"); ?></title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="<?=CSS?>"/>
        <link rel="stylesheet" href="<?=FONTAWESOME?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
        <link rel="icon" type="image/x-icon" href="<?=LOCAL . 'webroot/images/favicon.png'?>"/>
    </head>

    <body>
        <div class="default">
            <div id="main-content">
                <header>
                    <!-- Start Top Bar -->
                    <div class="fixed">
                        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
                            <button class="menu-icon" type="button" data-toggle="example-menu"></button>
                            <div class="title-bar-title">Menu</div>
                        </div>
                    </div>

                    <div class="top-bar navbar-fixed-top scrolled" id="example-menu">
                        <div class="top-bar-left">
                            <ul class="menu">
                                <li class="menu-text">Jean FORTEROCHE</li>
                                <li class="<?php if(App::getRouter()->getController() == 'accueil') echo 'active'; ?>"><a id="accueil" href="<?= LOCAL ?>">Accueil</a></li>
                                <li class="<?php if(App::getRouter()->getController() == 'blog') echo 'active'; ?>"><a id="blog" href="<?= LOCAL ?>blog?1">Les épisodes</a></li>
                            </ul>
                            <ul class="menu login">
                            <?php if (isset($_SESSION['id']) && isset($_SESSION['username'])){?>
                                    <li class="menu-text">Bonjour <?= $_SESSION['pseudo'];?></li>
                                    <li class="<?php if(App::getRouter()->getController() == 'admin') echo 'active'; ?>">
                                        <a id="tableau" href="<?= LOCAL ?>admin?1">Tableau de bord</a>
                                    </li>
                                    <li>
                                        <a id="deconnexion" href="<?= LOCAL ?>admin/deconnexion">Déconnexion</a>
                                    </li>
                            <?php } else { ?>
                                    <li>
                                        <a id="connexion" href="<?= LOCAL ?>admin?1">Connexion</a>
                                    </li>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- End Top Bar -->
                </header>
                <div class="callout large" id="bandeau">
                    <div class="row column text-center">
                        <h1>Billet simple pour l'Alaska</h1>
                        <h2 class="subheader">Un roman de Jean FORTEROCHE</h2>
                    </div>
                </div>

                <div class="content row medium-8 large-7 columns">

                    <?php echo $data['content']; ?>

                </div>

                <footer>
                    <div class="row medium-unstack">
                        <div class="columns">
                            <h4 class="marketing-site-footer-name">Yeti Snowcone</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita dolorem accusantium architecto id quidem, itaque nesciunt quam ducimus atque.</p>
                            <ul class="menu marketing-site-footer-menu-social simple">
                                <li><a href="#"><i class="fa fa-youtube-square" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="columns">
                            <h4 class="marketing-site-footer-title">Contactez moi</h4>
                            <div class="marketing-site-footer-block">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <p>100 W Rincon<br>San Francisco, CA 94015</p>
                            </div>
                            <div class="marketing-site-footer-block">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <p>01 02 03 04 05</p>
                            </div>
                            <div class="marketing-site-footer-block">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                <p>jean.forteroche@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="marketing-site-footer-bottom">
                        <div class="row large-unstack align-middle">
                            <div class="column">
                                <p>&copy; 2017 No rights reserved</p>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>

        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({
                mode : "specific_textareas",
                editor_selector : "montextarea",
                menubar: false,
                toolbar1: 'insertfile undo redo',
                toolbar2: 'formatselect | fontselect fontsizeselect | bold italic strikethrough | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                init_instance_callback: function (editor) {
                    editor.on('keydown', function (e) {
                        $('.erreurTextarea').remove();
                    });
                }
            });
        </script>
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script type='text/javascript'>
            $(document).foundation();
        </script>
        <script src="<?=JS?>"></script>

    </body>

</html>
