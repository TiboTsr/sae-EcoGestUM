<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>

    <link rel="stylesheet" href="assets/css/etu/etuProp.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">

        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière">
        </div>

        <div class="page-container">

            <h1 class="page-title">Signaler un objet</h1>

            <?php if (!empty($message)): ?>
                <div class="alert <?= $message_type == 'success' ? 'alert-success' : 'alert-danger' ?>"
                    style="padding: 15px; margin-bottom: 20px; border-radius: 5px; 
                    background-color: <?= $message_type == 'success' ? '#d4edda' : '#f8d7da' ?>; 
                    color: <?= $message_type == 'success' ? '#155724' : '#721c24' ?>;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="nom">Nom de l'objet</label>
                        <input type="text" id="nom" name="nom" placeholder="Ajouter le nom de l'objet" class="form-input">
                    </div>

                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="categorie">Catégorie</label>
                            <select id="categorie" name="categorie" class="form-input">
                                <option value="" disabled selected>choisir la catégorie</option>
                                <option value="Mobilier">Mobilier</option>
                                <option value="Électronique">Électronique</option>
                                <option value="Fournitures">Fournitures</option>
                                <option value="Sport">Sport</option>
                                <option value="Outils">Outils</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="quantite">Quantité</label>
                            <input type="number" id="quantite" name="quantite" placeholder="Ajouter une quantité" class="form-input">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description du problème</label>
                        <textarea id="description" name="description" placeholder="Ajouter une description" class="form-textarea"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Ajouter une photo</label>
                        <div class="upload-box">
                            <input type="file" id="photo" name="photo" class="file-input">
                            <label for="photo" class="upload-label">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn-reset">Réinitialiser</button>
                        <button type="submit" class="btn-submit">Soumettre</button>
                    </div>

                </form>
            </div>
        </div>

        <?php View::render('footer'); ?>

    </main>
</body>

</html>