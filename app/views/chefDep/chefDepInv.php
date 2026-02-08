<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($title ?? "Page") ?></title>
    <link rel="stylesheet" href="assets/css/chefDep/chepDepInv.css">
</head>
<body>

    <?php View::render('sidebar');?>  

    <main class="main-content">
        
        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière" />
        </div>

        <div class="page-container">
            
            <h1 class="page-title">Inventaire des ressources recyclables</h1>

            <div class="top-actions">
                <div class="search-box-internal">
                    <input type="text" placeholder="Saisir ici...">
                    <button class="btn-primary">Rechercher</button>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Quantité</th>
                            <th>État</th>
                            <th>Date d'ajout</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($objets)): ?>
                            <?php foreach($objets as $objet): ?>
                            <tr>
                                <td><?= htmlspecialchars($objet['nom_obj']) ?></td>
                                <td><?= htmlspecialchars($objet['nom_cat']) ?></td>
                                
                                <td><?= htmlspecialchars((float)$objet['quantite_obj']) ?></td>
                                
                                <td><?= htmlspecialchars($objet['etat_obj_']) ?></td>
                                
                                <td><?= date('d/m/Y', strtotime($objet['date_ajout_obj'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">Aucun objet trouvé dans cet inventaire.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

           <div class="bottom-actions">
                <span class="update-text">Dernière mise à jour : <?php date_default_timezone_set('Europe/Paris'); echo date('d/m/Y H:i:s'); ?></span>
                
                <a href="index.php?page=chefDepAddObj" class="btn-primary">Ajouter un objet</a>
            </div>

        </div>

        <?php View::render('footer'); ?>


    </main>
</body>
</html>
