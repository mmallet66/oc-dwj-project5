<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&amp;display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href='/public/css/style.css'>
    <title><?= 'Occaz\' Où - '.$title ?></title>
</head>
<body>
    <div id="page">

        <header>
            <a id="site-title" href="/"><h1><strong>O</strong>ccaz' <strong>O</strong>ù ?</h1></a>
            <section id="connection-area">
                <?php
                if(isset($_SESSION['username'])):
                ?>
                    <label for="connection-check" id="connection">
                        <div>
                            <i id="user-icon" class="far fa-user"></i>
                            <p id="header-username"><?= htmlspecialchars($_SESSION['username']) ?></p>
                        </div>
                    </label>
    
                    <input type="checkbox" name="connection-check" id="connection-check">
    
                    <div id="user-menu">
                        <ul class="user-menu-list">
                            <li class="user-menu-list-item"><a href="/user-account">Mon compte</a></li>
                        <?php if($_SESSION['username'] === 'admin'):?>
                            <li class="user-menu-list-item"><a href="/admin">Espace Administrateur</a></li>
                        <?php
                        else:
                        ?>
                            <li class="user-menu-list-item"><a href="/user-announces">Mes annonces</a></li>
                            <li class="user-menu-list-item"><a href="/create-announce">Déposer une annonce</a></li>
                        <?php
                        endif;
                        ?>
                        <li class="user-menu-list-item"><a href="/disconnect-user">Me déconnecter</a></li>
                        </ul>
                    </div>
                <?php
                else:
                ?>
        <!-- Connection link, displayed if a user is logged -->
        <a id="connection-link" href="/connection">Se connecter</a>
                <?php
                endif;
                ?>

            </section>
        </header>

        <section id="content-container" class="<?= $pageName ?>">
        <?= $content ?>
      </section>

    </div>
    <?php
    if($scriptPath!=null):
        echo "<script src='".$scriptPath."'></script>";
    endif;
    ?>
</body>
</html>