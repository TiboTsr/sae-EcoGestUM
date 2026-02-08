<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="assets/css/loginStyle.css">
    <link rel="stylesheet" href="assets/css/chefDep/chefDepHisto.css">
</head>

<body>

    <?php View::render('sidebar'); ?>


    <main class="main-content">
        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière" />
        </div>

        <div class="page-container">

            <h1 class="page-title">Historique des opérations de recyclage</h1>

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
                            <th>Date</th>
                            <th>Type d'objet</th>
                            <th>Quantité</th>
                            <th>Résultat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historique)): ?>
                            <?php foreach ($historique as $operation): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($operation['date_recycl'])) ?></td>
                                
                                <td>
                                    <?= htmlspecialchars($operation['nom_obj']) ?> 
                                    <span style="font-size:0.85em; color:#666;">
                                        (<?= htmlspecialchars($operation['nom_cat']) ?>)
                                    </span>
                                </td>
                                
                                <td><?= htmlspecialchars($operation['qte_recycl']) ?></td>
                                
                                <td><?= htmlspecialchars($operation['statut_recycl']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center; padding: 20px;">
                                    Aucune opération de recyclage enregistrée pour le moment.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="bottom-actions">
                <span class="update-text">Dernière mise à jour : <?php date_default_timezone_set('Europe/Paris');
                                                                    echo date('d/m/Y H:i:s'); ?></span>
            </div>

        </div>

        <?php View::render('footer'); ?>


    </main>
</body>

</html>