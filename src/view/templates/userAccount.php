<?php
$this->title = 'Mon Compte';
$this->scriptPath = '/public/js/formTraitment.js';

if(!empty($_SESSION['username'])): ?>
<article class="content">

    <h2>Mon compte</h2>

    <form action="/update-user" method="post">
        <fieldset>
            <legend>Données personnelles</legend>
            <input type="text" name="username" id="username" class="hidden" value="<?= $user->getUsername() ?>" disabled required>
            <p>
                <label for="gender">Civilité</label>
                <select name="gender" id="gender">
                    <?php if($user->getGender() === 'male'):?>
                    <option value="null"></option>
                    <option value="male" selected>Homme</option>
                    <option value="female">Femme</option>

                    <?php elseif($user->getGender() === 'female'): ?>
                    <option value="null"></option>
                    <option value="male">Homme</option>
                    <option value="female" selected>Femme</option>

                    <?php else: ?>
                    <option value="null" selected></option>
                    <option value="male">Homme</option>
                    <option value="female">Femme</option>
                    <?php endif; ?>
                </select>
            </p>
            <div>
                <p>
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" id="firstname" value="<?= ucfirst($user->getFirstName()) ?>">
                </p>
                <p>
                    <label for="name">Nom</label>
                    <input type="text" name="name" id="name" value="<?= strtoupper($user->getName()) ?>">
                </p>
            </div>
            <div>
                <p>
                    <label for="email">Courriel</label>
                    <input type="email" name="email" class="input-mail" id="email"  value="<?= $user->getEmail() ?>" required>
                    <span data-title="Doit correspondre à une adresse mail"></span>
                </p>
                <p>
                    <label for="phone">Téléphone</label>
                    <input type="tel" name="phone" class="input-phone" id="phone" value="0<?= $user->getPhone() ?>">
                    <span data-title="Veuillez saisir un numéro au format : 0102030405"></span>
                </p>
            </div>
                <p>
                    <label for="address">Adresse</label>
                    <input type="text" name="address" id="address" value="<?= $user->getAddress() ?>">
                </p>
            <div>
                <p>
                    <label for="zip-code">Code Postal</label>
                    <input type="text" name="zip-code" class="input-zip-code" id="zip-code" value="<?= $user->city->getZipCode() ?>">
                    <span data-title="Veuillez saisir un numéro au format : 75012"></span>
                </p>
                <p>
                    <label for="city">Ville</label>
                    <select name="city" id="city">
                        <option value="<?= $user->city->getName().'/'.$user->city->region->getCode() ?>"><?= strtoupper($user->city->getName()) ?></option>
                    </select>
                </p>
            </div>
        </fieldset>
        <input class="submit" type="submit" value="Mettre à jour mes données personnelle">
    </form>

    <form method="post" id="update-password">
        <fieldset>
            <legend>Mot de passe</legend>
            <div id="password-container"></div>
        </fieldset>
        <input class="submit" type="submit" value="Remplacer mon mot de passe">
    </form>

</article>
<?php
else:
    throw new Exception('Veuillez vous connecter');
endif;
?>