<?php
$ticket = $data[0];
$ticketCom = $data[1];
Config::set("site_name", Config::get("site_name").' - '.htmlspecialchars($ticket->getTitle()));
?>

<div class="blogBillet">
    <div class="blog-post">
        <div class="callout">
            <ul class="menu simple">
                <h3>
                    <li><small>Publié le : <?= $ticket->getDatePublication()?></small></li>
                    <li><small><?= $ticket->getDateModification() != $ticket->getDatePublication() ? '/ Modifié le : '. $ticket->getDateModification() : ''?></small></li>
                </h3>
            </ul>
            <ul class="menu simple" data-smooth-scroll>
                <li class="auteur"><i class="fa fa-user" aria-hidden="true"></i><span><?= htmlspecialchars($ticket->getAuthor())?></span></li>
                <li><a href="#commentaire" class="js-scrollTo"><?= count($ticketCom) . (count($ticketCom) > 1 ? ' Commentaires' : ' Commentaire'); ?></a></li>
            </ul>
        </div>
        <h1 class="title"><?= htmlspecialchars($ticket->getTitle())?></h1>
        <img class="thumbnail float-center" src="<?= LOCAL.'/webroot/images/'.$ticket->getId().'.jpg'?>">
        <p><?= $ticket->getContent()?></p>

        <hr>

        <h3 id="sendComment">Envoyer un commentaire</h3>
        <form action="commenter?<?=$ticket->getId()?>" method="post" id="add-comment">
            <label>Votre nom :</label><input type="text" name="nom" id="comNom">
            <label>Contenu :</label><textarea rows="8" cols="60" name="contenu" id="comContenu" required></textarea>
            <input type="hidden" name="id" value="<?=$ticket->getId() ?>">
            <input type="submit" id="envoyer" class="button" value="Envoyer">
        </form>
        <div id="commentaire"></div>
        <hr>

        <h3 class="h3Com"><i class="fa fa-comment-o" aria-hidden="true"></i><?= count($ticketCom) . (count($ticketCom) > 1 ? ' Commentaires' : ' Commentaire');?></h3>

        <?php foreach ($ticketCom as $comment){ ?>
        <div class="comment-section-container">
            <div class="comment-section-author">
                <div class="comment-section-name">
                    <div class="auteur">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <p><?= htmlspecialchars($comment->getComAuteur()) ?></p>
                    </div>
                    <p>Le <?= $comment->getComDate() ?></p>
                </div>
            </div>
            <div class="comment-section-text">
                <p><?= $comment->getComSignale() !=1 ? $comment->getComContenu() : "Ce commentaire a été signalé comme inapproprié."; ?></p>
                <?php
                if ($comment->getComSignale() == 1) {
                    echo '<i class="fa fa-times-circle-o infobulle" aria-hidden="true" aria-label="Commentaire signalé"></i>';
                } elseif ($comment->getComSignale() == 2) {
                    echo '<i class="fa fa-check-circle-o infobulle" aria-hidden="true" aria-label="Commentaire validé par l\'administrateur"></i>';
                } else {
                    echo '<a class="hollow button report" href="signaler?'.$comment->getComId().'"i>Signaler ce commentaire</a>';
                }
                ?>
            </div>
        </div>
        <?php } ?>

    </div>
</div>