<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Notifications') ?></title>
    <link rel="stylesheet" href="assets/css/enseignant/enseignantCollab.css">
</head>
<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">

        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière">
        </div>

        <div class="page-container">

            <div class="header-wrapper">
                <h1 class="page-title">Collaborer avec d'autres enseignants</h1>
            </div>
            <div class="content-wrapper"> 
                
                <div class="form-container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="destinataires">Titre du projet</label>
                            <input type="text" id="titre" name="titre" placeholder="Saisir ici..." class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="objet">Matériel nécessaire</label>
                            <input type="text" id="materiel" name="materiel" placeholder="Saisir ici..." class="form-input">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Description du projet</label>
                            <textarea id="message" name="message" placeholder="Saisir ici..." class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Date du projet</label>
                            <input type="date" id="date" name="date" placeholder="Saisir ici..." class="form-textarea"></textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">Envoyer</button>
                        </div>
                    </form>
                </div>
                
                <div class="notifications-history">

                    <div class="notification-card">
                        <h3 class="card-title">Projet Interdisciplinaire</h3>
                        <p class="card-text">
                            Collaboration avec le département de biologie pour un TP commun sur l’écosystème.
                        </p>
                        <button class="btn-attachement">S'inscrire</button>
                    </div>

                    <div class="notification-card">
                        <h3 class="card-title">Partage de ressources</h3>
                        <p class="card-text">
                        Mise à disposition de documents pédagogiques avec le département de physique.
                        </p>
                        <button class="btn-attachement">S'inscrire</button>
                    </div>

                    <div class="notification-card">
                        <h3 class="card-title">Atelier pédagogique</h3>
                        <p class="card-text">
                        Organisation d’un atelier avec l’équipe de mathématiques sur les statistiques.
                        </p>
                        <button class="btn-attachement">S'inscrire</button>
                    </div>
                </div>
            </div> 
        </div>

        <?php View::render('footer'); ?>

    </main>
</body>

</html>