<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="assets/css/sideBar.css">
    <link rel="stylesheet" href="assets/css/chepDepInv.css"> 
    <link rel="stylesheet" href="assets/css/chefDep/chefDepCollab.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">

        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière">
        </div>

        <div class="page-container">

            <h1 class="page-title">Collaboration inter-départements</h1>

            <?php if (!empty($message)): ?>
                <div class="alert" style="padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: <?= $message_type == 'success' ? '#d4edda' : '#f8d7da' ?>; color: <?= $message_type == 'success' ? '#155724' : '#721c24' ?>;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="content-wrapper"> 
                
                <div class="resources-table-container">
                    <h2 class="section-title">Ressources des autres départements</h2>
                    
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Département</th>
                                    <th>Objet</th> <th>Qté</th>
                                    <th>État</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ressources)): ?>
                                    <?php foreach ($ressources as $res): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($res['nom_dep']) ?></strong></td>
                                        <td>
                                            <?= htmlspecialchars($res['nom_obj']) ?>
                                            <br><small style="color:#888;"><?= htmlspecialchars($res['nom_cat']) ?></small>
                                        </td>
                                        <td><?= htmlspecialchars((float)$res['quantite_obj']) ?></td>
                                        <td><?= htmlspecialchars($res['etat_obj_']) ?></td>
                                        <td>
                                            <button class="btn-action" title="Demander cet objet">
                                                <i class="fa-solid fa-cart-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center;">Aucune ressource disponible dans les autres départements.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="form-container">
                    <h2 class="section-title">Ajouter un objet à partager</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="nom">Nom de l'objet</label>
                            <input type="text" id="nom" name="nom" placeholder="Ajouter le nom de l'objet" class="form-input" required>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="categorie">Catégorie</label>
                                <select id="categorie" name="categorie" class="form-input form-select" required>
                                    <option value="" disabled selected>Choisir une option</option>
                                    <option value="Mobilier">Mobilier</option>
                                    <option value="Électronique">Électronique</option>
                                    <option value="Fournitures">Fournitures</option>
                                    <option value="Sport">Sport</option>
                                    <option value="Outils">Outils</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="etat">État</label>
                                <select id="etat" name="etat" class="form-input form-select" required>
                                    <option value="" disabled selected>Choisir un état</option>
                                    <option value="neuf">Neuf</option>
                                    <option value="bon">Bon état</option>
                                    <option value="usage moyen">Usage moyen</option>
                                    <option value="use">Usé</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" placeholder="Ajouter une description" class="form-textarea"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="quantite">Quantité</label>
                                <input type="number" id="quantite" name="quantite" placeholder="Qté" class="form-input" min="1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Ajouter une photo</label>
                            <div class="upload-box">
                                <input type="file" id="photo" name="photo" class="file-input">
                                <i class="fa-solid fa-arrow-up-from-bracket upload-icon"></i>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="reset" class="btn-reset">Réinitialiser</button>
                            <button type="submit" class="btn-submit">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>

        <?php View::render('footer'); ?>

    </main>
</body>
</html>