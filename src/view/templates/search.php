<?php
$this->title = 'Recherche';
$this->scriptPath = '/public/js/research.js';
?>
<article class='content'>
    <h2>Annonces</h2>

    <div id='search-form-container'>
        <form id='search-form'>
            <div class='search-form-item'>
                <label for='subject' class='fas fa-search'></label>
                <input type='search' name='subject' id="research-subject" placeholder='Que recherchez-vous ?'>
            </div>
            <div class='search-form-item'>
                <label for='location' class='fas fa-map-marker-alt'></label>
                <input type='text' name='location' id='research-location' placeholder='Entrez un nom de ville'>
            </div>
            <div class='search-form-item'>
                <input class='submit' type='submit' value='Rechercher !'>
            </div>
        </form>
    </div>

    <div id='search-result-container'>
        <p>Résultats pour : <span id="what-search"><?= $location ?></span></p>
        <ul id='search-result-list'>
        <?php
        foreach ($announcesData as $value):
            $announce = new \Occazou\Src\Model\Announce();
            $announce->hydrate($value);
        ?>
            <a href='/announce/<?= $announce->getId() ?>' class='search-result-list-item'>
                <div class='item-picture-container'>
                <?php
                if($announce->getPictureName()):
                ?>
                <img src='/<?= UPLOADS_DIR.$announce->getPictureName() ?>' alt='announce-picture' class='item-picture'>
                <?php
                else:
                    ?>
                    <img src='/<?= UPLOADS_DIR.IMG_DEFAULT ?>' alt='announce-picture' class='item-picture'>
                    <?php
                endif;
                ?>
                </div>
                <div class='item-description-container'>
                    <aside class='item-description-title'>
                        <h3><?= htmlspecialchars($announce->getTitle()) ?></h3>
                        <span>
                            <i class='fas fa-map-marker-alt'></i>
                            <?= strtoupper(htmlspecialchars($announce->getAuthor()->getCity()->getName())) ?>
                        </span>
                    </aside>
                    <p class='item-description-price'><?= htmlspecialchars($announce->getPrice()) ?>€</p>
                    <?php
                    $announceText = strip_tags($announce->getText());
                    $announceText = (strlen($announceText)>450)? substr($announceText, 0, 450).'...' : $announceText;
                    ?>
                    <p class='item-description-text'><?= $announceText ?></p>
                    <p class='item-description-date'><?= htmlspecialchars($announce->getCreationDate()) ?></p>
                </div>
            </a>
        <?php
        endforeach;
        ?>
        </ul>
    </div>
</article>