<?php
$ticket = $data[0];
$message = $data[1];
$errorImage = $data[2];
Config::set("site_name", Config::get("site_name").' - ' . 'Ajouter');

if (isset($ticket)){
    $error = $ticket->getErreur();
}

if (isset($errorImage)) {
    $errorImage = $errorImage->getMessage();
}

if (isset($message)){
    echo '<div class="callout success"><p>', $message, '</p></div>
          <a type="button" class="button" href="' . LOCAL . 'admin?1">Retour au tableau de bord</a>';
} else { ?>
    <div class="adminAjouter">
        <form method="post" enctype="multipart/form-data" runat="server">
            <label>Titre :</label><input id="titre" type="text" name="titre" <?php if(!empty($_POST['titre'])) { echo ' value="', $_POST['titre'];} ?>">
            <?php if (isset($error) && in_array(Billet::TITRE_INVALIDE, $error)) echo '<div class="callout alert" id="erreurTitre">Ce champ est requis.</div>';?>

            <label>Contenu :</label><textarea id="textarea" class="montextarea" rows="8" cols="60" name="contenu"><?php if(!empty($_POST['contenu'])) { echo $_POST['contenu'];} ?></textarea>
            <?php if (isset($error) && in_array(Billet::CONTENU_INVALIDE, $error)){ echo '<div class="callout alert erreurTextarea">Ce champ est requis.</div>';}?>

            <label>Auteur :</label><input id="auteur" type="text" name="auteur" value="<?php echo $_SESSION['pseudo'] ?>" >
            <?php if (isset($error) && in_array(Billet::AUTEUR_INVALIDE, $error)) echo '<div class="callout alert" id="erreurAuteur">Ce champ est requis.</div>';?>

            <label for="image" class="button">Image à la une. (JPG, PNG ou GIF | max. <?= floor(Config::get('max_size') / 1000000)?> Mo) :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?= Config::get('max_size')?>" />
            <input type="file" class="show-for-sr" name="image" id="image" />
            <p>850 x 350 pixels pour un meilleur rendu.</p>
            <div class="cropped strechy-wrapper"></div>

            <?= isset($errorImage) ? '<div class="callout alert erreurImage">' . $errorImage . '</div>' :'';?>

            <input type="submit" class="button" name="enregistrer" value="Enregistrer"</input>
        </form>
    </div>
    
<?php } ?>


