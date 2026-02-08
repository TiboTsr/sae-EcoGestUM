<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="assets/css/loginLMU.css">
     
</head>

<body>
<div class="bg">
    <div class="connexion">
        <img src="images/logo-LeMansUniversite.png" alt="Logo de l'université du Mans">
        <div class="form">

        <form method="post" action="index.php?page=loginLMU&action=authenticate">
                <input type="text" placeholder="Identifiant*" id="id_user" name="id_user" required>
                <input type="password" placeholder="Mot de passe*" id="mdp_user" name="mdp_user" required>
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" class="toggle"></label>
                    <span>Se souvenir de moi</span>
                </div>
                <button type="submit" id="connexion">Se connecter</button><br>
            </form>

            <button id="first-connexion">1ère connexion</button><br>
            <a href="#">Mot de passe oublié ?</a><br>
            <p>
                Pour des raisons de sécurité, veuillez vous déconnecter et fermer votre navigateur lorsque vous avez fini d'accéder aux services authentifiés.
            </p>
            <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        </div>
    </div>
</div>
</body>

</html>