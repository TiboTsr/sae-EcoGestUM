<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="assets/css/tableaudebord.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>

    <?php View::render('header'); ?>

    <div class="conteneur-fond-ecran">
        <div class="conteneur-principal">

            <div class="grille-principale">

                <div class="colonne-gauche">

                    <div class="carte-transparente section-bienvenue">
                        <h1 class="titre-orange">Bienvenue sur ÉcoGest UM !</h1>
                        <h2 class="sous-titre-bleu">Mise à jour d'EcoGestUM mardi 02 décembre 2025</h2>
                        <p class="paragraphe-info">
                            Une opération de maintenance aura lieu sur la plateforme d'EcoGestUM mardi 02 décembre, de 12h00 à 14h00.
                        </p>
                        <p class="paragraphe-info">
                            Durant cette période, la plateforme sera temporairement inaccessible. Nous vous remercions de votre compréhension.
                        </p>
                        <p class="signature-equipe">L'équipe EcoGestUM</p>
                    </div>

                    <div class="carte-transparente section-calendrier">

                        <div class="entete-calendrier">
                            <h2 class="titre-mois" id="affichage-mois-annee">Chargement...</h2>
                            <div class="boutons-navigation">
                                <button id="btn-mois-precedent" title="Précédent">&#10094;</button>
                                <button id="btn-mois-suivant" title="Suivant">&#10095;</button>
                            </div>
                        </div>

                        <div class="grille-semaine">
                            <div class="nom-jour">Di</div>
                            <div class="nom-jour">Lu</div>
                            <div class="nom-jour">Ma</div>
                            <div class="nom-jour">Me</div>
                            <div class="nom-jour">Je</div>
                            <div class="nom-jour">Ve</div>
                            <div class="nom-jour">Sa</div>

                            <div id="liste-jours-calendrier" class="conteneur-numeros"></div>
                        </div>
                    </div>
                </div>

                <div class="colonne-droite">

                    <div class="carte-transparente carte-evenement">
                        <div class="image-evenement" style="background-image: url(images/Troc_etudiant.png);"></div>
                        <div class="texte-evenement">
                            <h3>Troc Party Étudiante</h3>
                            <p>Journée d'échange d'objets pour éviter le gaspillage – chaque participant repart avec un bon d'achat !</p>
                            <span class="date-evenement">Le 15 novembre</span>
                        </div>
                    </div>

                    <div class="carte-transparente carte-evenement">
                        <div class="image-evenement" style="background-image: url(images/Phones.png);"></div>
                        <div class="texte-evenement">
                            <h3>Collecte Solidaire de Téléphones</h3>
                            <p>Opération visant à collecter les vieux téléphones portables pour les recycler via une filière certifiée.</p>
                            <span class="date-evenement">Le 31 août</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php View::render('footer'); ?>

    <script src="assets/js/tableaudebord.js"></script>
</body>

</html>