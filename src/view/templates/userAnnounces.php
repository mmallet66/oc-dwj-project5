<?php
$this->title = 'Mes-Annonces';
$this->scriptPath = '/public/js/formTraitment.js';
?>
<article class="content">
    <h2>Mes annonces</h2>
    <?php
    if(!empty($data)):
    ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Contenu</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $key => $value):
                $announce = new \Occazou\Src\Model\Announce();
                $announce->hydrate($value);
            ?>
            <tr>
                <td><?= $announce->getCreationDate() ?></td>
                <td><a href="/announce/<?= $announce->getId() ?>"><?= htmlspecialchars($announce->getTitle()) ?></a></td>
                <td><?= htmlspecialchars(substr($announce->getText(),0,60)) ?></td>
                <td><?= htmlspecialchars($announce->getPrice()) ?></td>
                <td><button type="button" value="<?= $announce->getId() ?>">Supprimer</button></td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    else:
    ?>
    <p style='text-align:center;'>Vous n'avez actuellement aucune annonce en cours.</p>
    <?php
    endif;
    ?>
</article>