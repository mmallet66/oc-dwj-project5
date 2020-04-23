<?php
$this->title = 'Registration';
$this->scriptPath = '/public/js/formTraitment.js';
?>
<article class="content">

    <h2>Inscription</h2>
    <!-- action='new-user' -->
    <form action='new-user' method="post">
        <fieldset>
            <legend>Informations de connexion</legend>

            <p>
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" autocomplete="username" required>
            </p>
            <div>
                <p>
                    <label for="password1">Mot de passe <strong id="message-password" hidden>Mots de passe différents</strong></label>
                    <input type="password" name="password1" class="input-password" id="password1" autocomplete="new-password" required>
                    <span data-title="Au moins 8 caractères dont 1 min, 1 MAJ et 1 chiffre"></span>
                    <i class="fas fa-eye" id="show-password"></i>
                </p>
                <p>
                    <label for="password2">Confirmation du mot de passe</label>
                    <input type="password" name="password2" class="input-password" id="password2" autocomplete="new-password" required>
                </p>
            </div>
        </fieldset>

        <fieldset>
            <legend>Données personnelles</legend>

            <p>
                <label for="gender">Civilité</label>
                <select name="gender" id="gender">
                    <option value="null"></option>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                </select>
            </p>
            <div>
                <p>
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" id="firstname">
                </p>
                <p>
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name">
                </p>
            </div>
            <div>
                <p>
                    <label for="email">Courriel</label>
                    <input type="email" name="email" class="input-mail" id="email" placeholder="adresse@mail.fr" required>
                    <span data-title="Doit correspondre à une adresse mail"></span>
                </p>
                <p>
                    <label for="phone">Téléphone</label>
                    <input type="tel" name="phone" class="input-phone" id="phone" placeholder="0102030405">
                    <span data-title="Veuillez saisir un numéro au format : 0102030405"></span>
                </p>
            </div>
            <p>
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address">
            </p>
            <div>
                <p>
                    <label for="zip-code">Code Postal</label>
                    <input type="text" name="zip-code" class="input-zip-code" id="zip-code" placeholder="Ex. 75001">
                    <span data-title="Veuillez saisir un numéro au format : 75012"></span>
                </p>
                <p>
                    <label for="city">Ville</label>
                    <select name="city" id="city"></select>
                </p>
            </div>
        </fieldset>

        <input class="submit" type="submit" value="Je m'inscris">
    </form>
</article>