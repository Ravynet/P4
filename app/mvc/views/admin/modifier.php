<?php
$ticket = $data[0];
$ticketCom = $data[1];
$message = $data[2];
$errorImage = $data[3];
Config::set("site_name", Config::get("site_name").' - '.$ticket->getTitle());
?>

<?php
    $erreurs = $ticket->getErreur();

    if (isset($errorImage)) {
        $errorImage = $errorImage->getMessage();
    }

    if (isset($message)){
        echo '<div class="callout success"><p>', $message, '</p></div>
              <a type="button" class="button" href="' . LOCAL . 'admin?1">Retour au tableau de bord</a>';
    }
?>

<div class="adminModifier">
    <h3>
        <small>Publié le : <?php echo $ticket->getDatePublication();?> </small>
        <?php if ($ticket->getDateModification() != $ticket->getDatePublication()) {echo '<small> / Modifié le : ', $ticket->getDateModification(), '</small>';}?>
    </h3>
    <form method="post" enctype="multipart/form-data" runat="server">
        <label>Titre :</label><input type="text" name="titre" value="<?= $ticket->getTitle()?>">
        <?php if (isset($erreurs) && in_array(Billet::TITRE_INVALIDE, $erreurs)) echo '<div class="callout alert">Ce champ est requis.</div>';?>

        <label>Contenu :</label><textarea class="montextarea" rows="10" cols="60" name="contenu"><?= $ticket->getContent()?></textarea>
        <?php if (isset($erreurs) && in_array(Billet::CONTENU_INVALIDE, $erreurs)) echo '<div class="callout alert">Ce champ est requis.</div>';?>

        <label>Auteur :</label><input type="text" name="auteur" value="<?= $ticket->getAuthor()?>">
        <?php if (isset($erreurs) && in_array(Billet::AUTEUR_INVALIDE, $erreurs)) echo '<div class="callout alert">Ce champ est requis.</div>';?>

        <label for="image" class="button">Image à la une. (JPG, PNG ou GIF | max. <?= floor(Config::get('max_size') / 1000000)?> Mo) :</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= Config::get('max_size')?>" />
        <input type="file" class="show-for-sr" name="image" id="image" />
        <p>850 x 350 pixels minimum</p>
        <img class="image strechy-wrapper" src="<?= LOCAL.'/webroot/images/'.$ticket->getId().'.jpg'?>">
        <?= $errorImage ? '<div class="callout alert erreurImage">' . $errorImage . '</div>' :'';?>

        <input type="submit" class="button" name="modifier" value="Mettre à jour"</input>
    </form>

    <div id="commentaire"></div>
    <hr>

    <h3 class="h3Com"><i class="fa fa-comment-o" aria-hidden="true"></i><?= $ticket->getNbComSignale() . ($ticket->getNbComSignale() > 1 ? ' Commentaires signalés' : ' Commentaire signalé');?></h3>
    <?php foreach ($ticketCom as $comment){
        if ($comment->getComSignale() == 1) { ?>

                <div class="comment-section-container">
                    <div class="comment-section-author">
                        <div class="auteur">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <p><?=$comment->getComAuteur()?></p>
                        </div>
                        <p>Le <?= $comment->getComDate() ?></p>
                    </div>
                    <div>
                        <form action="supprimerCom?<?=$comment->getComId()?>" method="post" class="delete">
                            <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                            <button type="submit" class="hollow button button alert" href="supprimerCom?">Supprimer ce commentaire</button>
                        </form>
                        <form action="modererCom?<?=$comment->getComId()?>" method="post" class="moderate">
                            <input type="hidden" name="id" value="<?=$ticket->getId()?>">
                            <button type="submit" class="hollow button" href="modererCom?">Modérer ce commentaire</button>
                            <textarea class="montextarea" rows="10" cols="60" name="contenuCommentaire"><?=$comment->getComContenu()?></textarea>
                        </form>
                    </div>
                </div>
        <?php  }
    };?>
</div>
