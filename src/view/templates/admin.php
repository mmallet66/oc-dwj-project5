<?php
$this->title = 'Administation';
$this->scriptPath = '/public/js/admin.js';
?>
<article class="content">
    <h2>Espace Administrateur</h2>
    <?php
    if(!empty($usersData)):
    ?>
    <h3>Données des utilisateurs :</h3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>eMail</th>
                <th>Ville</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($usersData as $userData):
                $user = new \Occazou\Src\Model\User();
                $user->hydrate($userData);
                if($user->getUsername() != 'admin'):
            ?>
            <tr>
                <td><?= $user->getId() ?></td>
                <td><a href="/admin/manage-user/<?= $user->getUsername() ?>"><?= htmlspecialchars($user->getUsername()) ?></a></td>
                <td><?= htmlspecialchars($user->getEmail()) ?></td>
                <td><?= htmlspecialchars($user->getCity()->getName()) ?></td>
                <td><button type="button" name="delete-user" value="<?= $user->getUsername() ?>">Supprimer</button></td>
            </tr>
            <?php
                endif;
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    endif;

    if(!empty($announcesData)):
    ?>
    <h3>Données des annonces :</h3>
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
            foreach ($announcesData as $value):
                $announce = new \Occazou\Src\Model\Announce();
                $announce->hydrate($value);
            ?>
            <tr>
                <td><?= $announce->getCreationDate() ?></td>
                <td><a href="/announce/<?= $announce->getId() ?>"><?= htmlspecialchars($announce->getTitle()) ?></a></td>
                <td><?= htmlspecialchars(substr($announce->getText(),0,60)) ?></td>
                <td><?= htmlspecialchars($announce->getPrice()) ?></td>
                <td><button type="button" name="remove-announce" value="<?= $announce->getId() ?>">Supprimer</button></td>
            </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>
    <?php
    endif;
    ?>
</article>