<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>

    <?php View::render('header'); ?>

    <div class="bg">
        <div class="card">
            <h1>Bienvenue</h1>
            <p>Pour continuer, veuillez vous connecter :</p>

            <a href="index.php?page=loginLMU" class="button-lmu">Avec votre compte<img src='images\logo_LEMANS_UNIVERSITE_Blanc-01.png' alt="Logo de l'université du Mans"></a>

            <p>Ou</p>

            <a href="#" class="visitor-btn">Visiteur</a>
        </div>
    </div>

    <?php View::render('footer'); ?>

</body>

</html>