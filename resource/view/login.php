<?php
$this->titre = "Mon Blog - Connexion"
?>
<p>Vous devez être connecté pour accéder à cette zone.</p>
<form action="Login/connect" method="post">
    <label for="login">Login</label>
    <input name="login" id="login" type="text" placeholder="Entrez votre login" value="admin" required autofocus>
    <br>
    <label for="mdp">Mot de passe</label>
    <input name="mdp" id="mdp" type="password" placeholder="Entrez votre mot de passe" value="secret" required>
    <br>
    <button type="submit">Connexion</button>
</form>
<?php if (isset($msgErreur)): ?>
    <p><?= $msgErreur ?></p>
<?php endif; ?>
