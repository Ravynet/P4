<?php
Config::set("site_name", Config::get("site_name").' - Login');
if (isset($data[0])){
    $error = $data[0];
}
?>

<div class="adminLogin">
    <form method="post" class="log-in-form">
      <h4 class="text-center">Connexion Administrateur</h4>
      <label>Email
        <input type="email" name="username" placeholder="exemple@exemple.com">
      </label>
      <label>Mot de passe
        <input type="password" name="password" placeholder="Mot de passe">
      </label>
        <label><input id="connexion-auto" type="checkbox" name="connexion-auto">Se souvenir de moi</label>
      <input type="submit" class="button expanded" name="login" value="Connexion">
      <p class="text-center"><a href="#">Mot de passe oublié ?</a></p>
    </form>
    <?php
    if (isset($error)){ ?>
        <div class="callout alert"><p> <?= $error ?></p></div>
    <?php
    }
    ?>
</div>