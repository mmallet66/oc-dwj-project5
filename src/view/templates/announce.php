<?php
$this->title = 'Announce';
?>
<article class="content">
    <h2 id="announce-title"><?= htmlspecialchars($announce->getTitle()) ?></h2>

    <div id="img-container">
        <?php
        if($announce->getPictureName()):
        ?>
        <img src="/<?= UPLOADS_DIR.$announce->getPictureName() ?>">
        <?php
        else:
            ?>
            <img src="/<?= UPLOADS_DIR.IMG_DEFAULT ?>">
            <?php
        endif;
        ?>
    </div>

    <div id="price-container">
        <h4>Prix : <strong id="price"><?= htmlspecialchars($announce->getPrice()) ?>€</strong></h4>
    </div>

    <hr>

    <div id="description-container">
        <h4>Description :</h4>
        <p id="description"><?= htmlspecialchars($announce->getText()) ?></p>
        <p id="announce-date"><?= $announce->getCreationDate() ?></p>
    </div>

    <hr>

    <div id="author-container">
        <h4>Auteur :</h4>
            <table>
                <tr>
                    <td>Ville : </td>
                    <td><?= $announce->getAuthor()->getCity()->getName() ?></td>
                </tr>
                <tr>
                    <td>Mail : </td>
                    <td><?= htmlspecialchars($announce->getAuthor()->getEmail()) ?></td>
                </tr>
                <?php
                if($announce->getAuthor()->getPhone()!=null):
                ?>
                <tr>
                    <td>Tél : </td>
                    <td><?= "0".htmlspecialchars($announce->getAuthor()->getPhone()) ?></td>
                </tr>
                <?php
                endif;
                ?>
            </table>
    </div>

</article>