<?php
$this->title = 'Connexion';
$this->scriptPath = '/public/js/connection.js';
?>
<article class="content">
    <h2>Se Connecter</h2>

    <form method="post">
        <p>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" required>
        </p>
        <p>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required autocomplete="on">
        </p>
        <p>
            <input class="submit" type="submit" value="Me connecter">
        </p>
    </form>

    <p>Vous n'êtes pas encore inscrit ? <a href="registration.html">S'inscrire</a></p>
</article>