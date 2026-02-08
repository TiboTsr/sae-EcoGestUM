<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="assets/css/nosvaleurs.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php View::render('header'); ?>

    <div class="conteneur-fond-ecran">

        <div class="conteneur-principal relative">

            <img src="images/logo_recyclage.png" alt="" class="logo-central-fond">

            <div class="grille-valeurs">

                <div class="carte-valeur">
                    <h2 class="titre-orange">Bienvenue sur ÉcoGest UM !</h2>
                    <p>
                        Notre initiative vise à transformer la gestion des déchets et la sensibilisation écologique à l'Université du Mans. Grâce à notre plateforme, nous favorisons une meilleure gestion des ressources, la réduction des déchets, et un engagement collectif pour un campus plus durable.
                    </p>
                </div>

                <div class="carte-valeur">
                    <h2 class="titre-orange">Des chiffres qui parlent</h2>
                    <p>
                        En quelques mois, ÉcoGest UM a permis de recycler plus de 500 tonnes de matériaux dont le papier, le plastique et le métal, réduisant ainsi de 120 tonnes l'empreinte carbone de l'université. Notre taux de réutilisation atteint aujourd'hui 82%, une preuve que la communauté universitaire s'engage activement pour la préservation de l'environnement.
                    </p>
                </div>

                <div class="carte-valeur">
                    <h2 class="titre-orange">Un engagement collectif</h2>
                    <p>
                        Plus de 30 campagnes d'éco-actions ont été lancées, mobilisant étudiants et personnels, pour encourager des comportements responsables et durables. Notre plateforme facilite la traçabilité, la planification et l'évaluation des actions pour un impact positif mesurable.
                    </p>
                </div>

                <div class="carte-valeur">
                    <h2 class="titre-orange">Notre vision</h2>
                    <p>
                        ÉcoGest UM veut bâtir un campus zéro déchet, en renforçant la sensibilisation, en innovant dans la gestion des ressources, et en inspirant d'autres établissements à suivre cette voie. Ensemble, faisons de l'Université du Mans un exemple d'écologie concrète et participative.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <?php View::render('footer'); ?>

</body>

</html>