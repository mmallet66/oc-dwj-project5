<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
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
                            <p id="username"><?= htmlspecialchars($_SESSION['username']) ?></p>
                        </div>
                    </label>
    
                    <input type="checkbox" name="connection-check" id="connection-check">
    
                    <div id="user-menu">
                        <ul class="user-menu-list">
                            <li class="user-menu-list-item"><a href="myAccount.html">Mon compte</a></li>
                            <li class="user-menu-list-item"><a href="myAnnounces.html">Mes annonces</a></li>
                            <li class="user-menu-list-item"><a href="createAnnounce.html">Déposer une annonce</a></li>
                            <li class="user-menu-list-item"><a href="#">Me déconnecter</a></li>
                        </ul>
                    </div>
                <?php
                else:
                ?>
        <!-- Connection link, displayed if a user is logged -->
        <a id="connection-link" href="connection">Se connecter</a>
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