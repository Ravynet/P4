<?php
$tickets = $data[0];
$nbPage = $data[1];
$cPage = $data[2];
$sumComReported = $data[3];
Config::set("site_name", Config::get("site_name").' - Administration');
?>

<div class="adminIndex">

    <?php if (empty($tickets)) {?>
        <h3>Aucun épisode de publié pour le moment.</h3>
        <div class="callout">
            <ul class="menu simple">
                <li><a href="admin/ajouter">Ajouter un nouvel article</a></li>
            </ul>
        </div>
    <?php } else {?>

        <?php if ($sumComReported['nbComSignaleTotal'] > 0) { ?>
            <div class="callout alert">
                <ul class="menu simple">
                    <li>
                        <a href="admin/commentaire-1">Vous avez <?=$sumComReported['nbComSignaleTotal']?> <?= $sumComReported['nbComSignaleTotal'] > 1 ? ' commentaires signalés' : 'commentaire signalé'?></a>
                    </li>
                </ul>
            </div>
        <?php
        }
        ?>
        <div class="callout">
            <ul class="menu simple">
                <li><a href="admin/ajouter">Ajouter un nouvel article</a></li>
            </ul>
        </div>
        <?php
        if (isset($message)){
            echo '<div class="callout success"><p>', $message, '</p></div>';
        }
        ?>
        <div class="blog-post">
            <table class="table-expand">
                <thead>
                <tr class="table-expend-row">
                    <th class="text-left date" width="17%">Date publication</th>
                    <th class="text-left" width="25%">Titre</th>
                    <th class="text-center nbComs" width="18%">Commentaires</th>
                    <th class="text-center comSignale" width="18%">Commentaires signalés</th>
                    <th class="text-center" width="22%"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tickets as $ticket) { ?>
                    <tr class="table-expend-row" data-open-details>
                        <td class="date"><?= $ticket->getDatePublication();?></td>
                        <td><?= strlen($ticket->getTitle()) > 50 ? substr($ticket->getTitle(), 0, 50)." ..." : $ticket->getTitle();?></td>
                        <td class="text-center nbComs"> <?= $ticket->getnbComs();?> </td>
                        <td class="text-center comSignale"> <?= $ticket->getNbComSignale() > 0 ?'<a class="comSignale" href="admin/modifier-'.$ticket->getId().'#commentaire">'.$ticket->getNbComSignale().'</a>':'-';?><a></td>
                        <td>
                            <a class="button primary" href="admin/modifier-<?=$ticket->getId();?>">Modifier</a>
                            <button id="delete" class="button alert" data-open="Modal">Supprimer</button>
                            <div class="reveal" id="Modal" data-reveal>
                                <h1>Attention !</h1>
                                <p class="lead">Voulez-vous vraiment supprimer cet épisode ?</p>

                                <!-- MINI FORMULAIRE POUR PROTEGER CONTRE LES ATTAQUES XSS EN REMPLACEMENT DE TOKEN CSRF -->
                                <form action="admin/supprimer" method="post">
                                    <button class="button" data-close aria-label="Close modal" type="button">Annuler</button>
                                    <input type="hidden" name="id" value="<?= $ticket->getId(); ?>">
                                    <button type="submit" class="button alert" href="admin/supprimer-<?= $ticket->getId();?>">Supprimer</button>
                                </form>
                                <button class="close-button" data-close aria-label="Close modal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <?php include("../app/mvc/views/core/paging.php") ?>

        </div>
    <?php } ?>

</div>