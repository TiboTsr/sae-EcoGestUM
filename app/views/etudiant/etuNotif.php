<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Signaler un Besoin') ?></title>
    <link rel="stylesheet" href="assets/css/etu/etuNotif.css">
</head>

<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">
        <div class="hero-banner-main">
            <img src="images/banner.jpg" alt="Bannière Architecturale Campus">
        </div>

        <article class="content-article">

            <section class="notification-settings-section">
                <h1>Paramètre des notifications</h1>

                <div class="setting-card">
                    <p>Souhaitez-vous être alerté lorsqu'une nouvelle ressource est disponible ?</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="resource-alert" value="oui" checked> Oui
                        </label>
                        <label>
                            <input type="radio" name="resource-alert" value="non"> Non
                        </label>
                    </div>
                </div>

                <div class="setting-card">
                    <p>Souhaitez-vous être alerté lorsqu'une nouvelle Campagne est disponible ?</p>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="campaign-alert" value="oui"> Oui
                        </label>
                        <label>
                            <input type="radio" name="campaign-alert" value="non" checked> Non
                        </label>
                    </div>
                </div>

                <p class="email-info">Toute les notifications seront envoyés sur votre messagerie <a href="https://webmail.univ-lemans.fr/">Ent Université Le Mans</a></p>

                <div class="action-button-container">
                    <button class="btn-activate-notifications">Activer mes notifications</button>
                </div>

            </section>

        </article>

        <?php View::render('footer'); ?>
    </main>
</body>

</html>