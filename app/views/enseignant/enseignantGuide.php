<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Signaler un Besoin') ?></title>
    <link rel="stylesheet" href="assets/css/enseignant/enseignantGuide.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">
        <div class="hero-banner-main">
            <img src="images/banner.jpg" alt="Bannière Architecturale">
        </div>

        <article class="content-article">

            <section class="intro-section">
                <h1>Consulter les conseils et bonnes pratiques pour optimiser le recyclage sur le campus</h1>
                <p>Ce guide est destiné à l'ensemble du personnel et des étudiants de l'Université du Mans pour garantir une gestion des déchets efficace et responsable. En adoptant les bonnes pratiques de tri, nous contribuons collectivement à la réduction de notre empreinte environnementale et à la valorisation des ressources. <strong>Le tri est l'affaire de tous !</strong></p>
            </section>

            <section class="objetifs-section">
                <h2>Objectifs</h2>
                <div class="card-objetifs">
                    <p class="subtitle">Nos objectifs pour l'année universitaire</p>
                    <p>Notre but est de rendre le recyclage <strong>simple, accessible et performant</strong> pour tous. Nous visons une augmentation de <strong>20% du volume de papier et carton recyclé</strong> et le déploiement de <strong>nouvelles bornes de tri pour les déchets organiques</strong> dans les restaurants universitaires d'ici la fin de l'année. Ces initiatives passent par une information claire et une logistique adaptée.</p>
                    <div class="placeholder-images">
                        <div class="image-box"></div>
                        <div class="image-box"></div>
                    </div>
                </div>
            </section>

            <section class="fonctionnalites-section">
                <div class="card-fonctionnalites">
                    <h2>Fonctionnalités Clés du Tri</h2>
                    <p class="subtitle">Maîtriser les procédures de recyclage</p>
                    <p>Pour garantir l'efficacité de la chaîne de recyclage, il est essentiel de connaître les <strong>cinq principaux flux</strong> gérés sur le campus :</p>

                    <ul class="key-flows-list">
                        <li><i class="fas fa-dot-circle blue-dot"></i> <strong>Papier/Carton :</strong> Bac Bleu (Journaux, magazines, boîtes en carton).</li>
                        <li><i class="fas fa-dot-circle yellow-dot"></i> <strong>Plastique/Métal/Emballages :</strong> Bac Jaune (Bouteilles, conserves, barquettes).</li>
                        <li><i class="fas fa-dot-circle green-dot"></i> <strong>Verre :</strong> Conteneurs dédiés à l'extérieur (Bouteilles, pots, bocaux).</li>
                        <li><i class="fas fa-dot-circle gray-dot"></i> <strong>Déchets Non Recyclables :</strong> Bac Gris (Déchets alimentaires, serviettes usagées).</li>
                        <li><i class="fas fa-dot-circle red-dot"></i> <strong>Spécifiques :</strong> Points de collecte (Piles, cartouches d'encre, DEEE).</li>
                    </ul>
                </div>
            </section>

            <section class="utilisation-section">
                <div class="text-block">
                    <h2>Guide d'Utilisation des Points de Tri</h2>
                    <p class="subtitle">Les étapes simples pour bien trier</p>
                    <p><strong>1. Repérez :</strong> Chaque étage et chaque salle de pause dispose d'un point de tri avec des poubelles de couleur distincte. Lisez attentivement les étiquettes de consignes. En cas de doute, jetez dans le bac gris pour éviter de compromettre le recyclage d'un lot entier.</p>
                    <p><strong>2. Préparez :</strong> Videz tout contenu liquide ou alimentaire des emballages (bouteilles, boîtes de conserve) avant de les jeter. Les bouchons peuvent être laissés sur les bouteilles. N'empilez pas les cartons, pliez-les pour gagner de la place.</p>
                    <p><strong>3. Signalez :</strong> Si une borne de tri est pleine ou endommagée, utilisez la fonction "Signaler un besoin" dans la barre latérale pour alerter rapidement le service de maintenance et de gestion des déchets. Cela assure la continuité de nos efforts de recyclage.</p>
                </div>
                <div class="image-illustration">
                    <img src="images/image 1.png" alt="Illustration Utilisation du tri">
                </div>
            </section>

        </article>


        <?php View::render('footer'); ?>

    </main>


</body>

</html>