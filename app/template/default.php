<!DOCTYPE html>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-119309614-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-119309614-1');
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-WNDNBMN');</script>
        <!-- End Google Tag Manager -->

        <title><?= Config::get("site_name"); ?></title>
        <meta name="description" content="<?= Config::get("description"); ?>" />
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="<?=CSS?>"/>
        <link rel="stylesheet" href="<?=FONTAWESOME?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
        <link rel="icon" type="image/x-icon" href="<?=LOCAL . 'webroot/images/favicon.png'?>"/>
        <meta name="google-site-verification" content="jOYyk2tZwAF8XU9ubJyz5qGzzMkKtiacY-xSuH_3TGE" />
    </head>

    <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WNDNBMN"
                      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
        <div class="default">
            <div id="main-content">
                <!-- Start Top Bar -->
                <input type="checkbox" class="menu-toggle" id="menu-toggle">
                <div class="mobile-bar">
                    <label for="menu-toggle" class="menu-icon1">
                        <span></span>
                    </label>
                </div>

                <header class="header">
                    <nav class="navbar">
                        <ul>
                            <li class="menu-text">Jean FORTEROCHE</li>
                            <li class="<?php if(App::getRouter()->getController() == 'accueil') echo 'active'; ?>"><a id="accueil" href="<?= LOCAL ?>">Accueil</a></li>
                            <li class="<?php if(App::getRouter()->getController() == 'blog') echo 'active'; ?>"><a id="blog" href="<?= LOCAL ?>blog-1">Les épisodes</a></li>
                        </ul>
                        <ul>
                            <?php if (isset($_SESSION['id']) && isset($_SESSION['username'])){?>
                                <li class="menu-text">Bonjour <?= $_SESSION['pseudo'];?></li>
                                <li class="roundNotification <?php if(App::getRouter()->getController() == 'admin') echo 'active'; ?>">
                                    <a id="tableau" href="<?= LOCAL ?>admin-1">Tableau de bord
                                        <span class="roundNotification_count"><?= $_SESSION['sumComReported']['nbComSignaleTotal']; ?></span>
                                    </a>
                                </li>
                                <li>
                                    <a id="deconnexion" href="<?= LOCAL ?>admin/deconnexion">Déconnexion</a>
                                </li>
                            <?php } else { ?>
                                <li>
                                    <a id="connexion" href="<?= LOCAL ?>admin-1">Connexion</a>
                                </li>
                            <?php } ?>

                        </ul>
                    </nav>
                </header>
                <!-- End Top Bar -->

                <div class="container">

                <div class="callout large" id="bandeau">
                    <div class="row column text-center">
                        <h1>Billet simple pour l'Alaska</h1>
                        <h2 class="subheader">Un roman de Jean FORTEROCHE</h2>
                    </div>
                </div>

                <div class="content row medium-11 columns">

                    <?php echo $data['content']; ?>

                </div>

                <footer>
                    <div class="row medium-unstack">
                        <div class="columns">
                            <h3 class="marketing-site-footer-name">Yeti Snowcone</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita dolorem accusantium architecto id quidem, itaque nesciunt quam ducimus atque.</p>
                            <ul class="menu marketing-site-footer-menu-social simple">
                                <li><a href="#"><i class="fa fa-youtube-square" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <div class="columns">
                            <h3 class="marketing-site-footer-title">Contactez moi</h3>
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
        </div>

        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({
                mode : "specific_textareas",
                editor_selector : "montextarea",
                menubar: false,

                toolbar1: 'insertfile undo redo',
                toolbar2: 'formatselect | fontselect fontsizeselect | bold italic strikethrough | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat |',
                block_formats: 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Preformatted=pre',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                init_instance_callback: function (editor) {
                    editor.on('keydown', function (e) {
                        $('.erreurTextarea').remove();

                    });
                $('.mce-notification').remove();
                }
            });
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
        <script type='text/javascript'>
            $(document).foundation();
        </script>
        <script src="<?=JS?>"></script>

    </body>

</html>