<?php
$tickets = $data[0];
$nbPage = $data[1];
$cPage = $data[2];
Config::set("site_name", Config::get("site_name").' - Les épisodes');
?>

<div class="blogIndex">

    <?php if (empty($tickets)) {?>
        <h3>Aucun épisode de publié pour le moment.</h3>
        <h4>Revenez un peu plus tard ...</h4>
    <?php } else {?>

        <?php foreach ($tickets as $ticket) { ?>
            <section class="blog-post">
                <h1><a href="blog/billet-<?= $ticket->getId()?>"><?= htmlspecialchars($ticket->getTitle())?></a>
                    <div>
                        <small id="publie">Publié le : <?= $ticket->getDatePublication()?></small>
                        <small id="modifie"><?= $ticket->getDateModification() != $ticket->getDatePublication() ? 'Modifié le : '. $ticket->getDateModification() : ''?></small>
                    </div>
                </h1>
                <img class="thumbnail" src="<?= LOCAL.'/webroot/images/'.$ticket->getId().'.jpg'?>" alt="Image <?=htmlspecialchars($ticket->getTitle())?>">
                <div class="content">
                    <?= substr($ticket->getContent(), 0, 1000)." ..."?>
                </div>

                <div class="callout">
                    <ul class="menu simple">
                        <li class="auteur"><i class="fa fa-user" aria-hidden="true"></i><span><?= htmlspecialchars($ticket->getAuthor())?></span></li>
                        <li><a href="blog/billet-<?= $ticket->getId() . '#commentaire' ?>"><?= $ticket->getNbcoms() . ($ticket->getNbcoms() > 1 ? ' Commentaires' : ' Commentaire')?></a></li>
                    </ul>
                </div>
            </section>
       <?php } ?>

        <?php include("../app/mvc/views/core/paging.php") ?>

    <?php } ?>
</div>