<?php
$this->title = 'Création Annonce';
$this->scriptPath = '/public/js/formTraitment.js';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if(!empty($_SESSION['username'])): ?>
<article class="content">
    <h2>Créer une annonce</h2>

    <form action="" method="POST" enctype="multipart/form-data">

        <fieldset>
            <legend>Titre de l'annonce</legend>
            <input type="text" name="announceTitle" id="announceTitle" required>
        </fieldset>

        <fieldset>
            <legend>Texte de l'annonce</legend>
            <textarea type="text" name="announceText" id="announceText" required></textarea>
        </fieldset>

        <fieldset>
            <legend>Prix</legend>
            <input type="text" name="price" class="input-price" id="price" required>
        </fieldset>

        <fieldset>
            <legend>Photo de l'annonce</legend>
            <input type="file" name="picture" class="input-picture" id="picture">
        </fieldset>

        <input class="submit" type="submit" value="Enregistrer">
    </form>
</article>
<?php
else:
    throw new Exception('Vous devez être connecté pour déposer une annonce');
endif;
?>