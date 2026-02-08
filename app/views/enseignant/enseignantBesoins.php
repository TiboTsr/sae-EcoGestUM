<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Signaler un Besoin') ?></title>
    <link rel="stylesheet" href="assets/css/enseignant/enseignantBesoins.css">
</head>

<body>

    <?php View::render('sidebar'); ?>
    <main class="main-content">
        <div class="hero-banner-main">
            <img src="images/banner.jpg" alt="Bannière Architecturale Campus">
        </div>

        <article class="content-article-signal">

            <h1 class="page-title-signal">Signaler un besoin</h1>

            <div class="content-wrapper-signal">

                <div class="form-container-signal">
                    <form action="#" method="POST">

                        <div class="form-group-signal">
                            <label for="type-materiel">Type de matériel demandé</label>
                            <input type="texte" id="typeMateriel" name="typeMateriel" placeholder="Entrer ici..." class="form-input-signal">
                        </div>

                        <div class="form-group-signal">
                            <label for="quantite">Quantité</label>
                            <input type="number" id="quantite" name="quantite" placeholder="Saisir un nombre" class="form-input-signal">
                        </div>

                        <div class="form-group-signal">
                            <label for="usage">Usage</label>
                            <textarea id="usage" name="usage" placeholder="Saisir ici..." class="form-textarea-signal"></textarea>
                        </div>

                        <div class="form-group-signal">
                            <label for="date-besoin">Date de besoin (facultatif)</label>
                            <input type="date" id="date-besoin" name="date-besoin" placeholder="Choisir une date" class="form-input-signal">
                        </div>

                        <div class="form-actions-signal">
                            <button type="submit" class="btn-submit-signal">Envoyer</button>
                        </div>
                    </form>
                </div>

                <div class="history-container-signal">
                    <h2 class="history-title-signal">Historiques des demandes</h2>

                    <div class="demand-card status-pending">
                        <p class="card-title-signal">Vidéoprojecteur portable</p>
                        <p class="card-description-signal">Besoin d'un vidéoprojecteur pour le cours de physique sur les expériences de lumière.</p>
                        <span class="status-badge status-pending-badge">En attente</span>
                    </div>

                    <div class="demand-card status-completed">
                        <p class="card-title-signal">Kits de chimie</p>
                        <p class="card-description-signal">Demande de kits de chimie pour les TP de seconde année.</p>
                        <span class="status-badge status-completed-badge">Terminé</span>
                    </div>

                    <div class="demand-card status-refused">
                        <p class="card-title-signal">Tablettes numériques</p>
                        <p class="card-description-signal">Demande de 8 tablettes pour l'utilisation d'une application pédagogique.</p>
                        <span class="status-badge status-refused-badge">Refusé</span>
                    </div>

                </div>
            </div>

        </article>

        <?php View::render('footer'); ?>
    </main>
</body>

</html>