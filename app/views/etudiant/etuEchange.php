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

            <h1 class="page-title">Proposer un objet à recycler</h1>

            <div class="exchange-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 28px; align-items: start;">
                <section>
                    <h2 style="margin-bottom: 14px; font-size: 20px;">Mes réservations</h2>
                    <div class="reservation-list" style="display: grid; gap: 16px;">
                        <?php if (!empty($reservations)): ?>
                            <?php foreach ($reservations as $res): ?>
                                <article class="reservation-card" style="border: 1px solid #e1e5ee; border-radius: 10px; overflow: hidden; box-shadow: 0 6px 16px rgba(0,0,0,0.08);" 
                                    data-nom="<?= htmlspecialchars($res['nom_obj'] ?? '') ?>"
                                    data-description="<?= htmlspecialchars($res['description_obj'] ?? '') ?>"
                                    data-quantite="<?= htmlspecialchars($res['qte_res'] ?? '') ?>">
                                    <div style="background: linear-gradient(135deg, #0e2a66 0%, #1b3d8a 100%); color: #fff; padding: 12px 16px; font-weight: 700; font-size: 15px;">
                                        <?= htmlspecialchars($res['nom_obj'] ?? 'Objet réservé') ?>
                                    </div>
                                    <div style="padding: 14px 16px; display: grid; gap: 6px;">
                                        <div style="color: #555; font-size: 14px; line-height: 1.4;">
                                            <?= htmlspecialchars($res['description_obj'] ?? 'Aucune description') ?>
                                        </div>
                                        <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 13px; color: #0e2a66; font-weight: 600;">
                                            <span>Quantité: <?= htmlspecialchars($res['qte_res'] ?? '1') ?></span>
                                            <span>Statut: <?= htmlspecialchars($res['statut_res'] ?? 'En attente') ?></span>
                                        </div>
                                        <div style="font-size: 12px; color: #7a7f8a;">
                                            Demandé le <?= htmlspecialchars(date('d/m/Y', strtotime($res['date_res'] ?? 'now'))) ?>
                                        </div>
                                        <div style="margin-top: 8px;">
                                            <button type="button" class="btn-select" style="background: #0e2a66; color: #fff; border: none; padding: 10px 14px; border-radius: 8px; cursor: pointer; font-weight: 600;">Sélectionner</button>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding: 14px 16px; border: 1px dashed #cbd2e0; border-radius: 10px; color: #6b7280; font-size: 14px;">
                                Vous n'avez pas encore de réservations.
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section>
                    <?php if (!empty($message)): ?>
                        <div class="alert <?= $message_type == 'success' ? 'alert-success' : 'alert-danger' ?>"
                            style="padding: 15px; margin-bottom: 20px; border-radius: 5px; 
                            background-color: <?= $message_type == 'success' ? '#d4edda' : '#f8d7da' ?>; 
                            color: <?= $message_type == 'success' ? '#155724' : '#721c24' ?>;">
                            <?= $message ?>
                        </div>
                    <?php endif; ?>

                    <div id="form-confirmation" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: #d4edda; color: #155724; font-weight: 600;">
                        Votre demande d'échange a été envoyée.
                    </div>
                    <div id="form-error" style="display: none; padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: #f8d7da; color: #721c24; font-weight: 600;">
                        Merci de remplir tous les champs du formulaire.
                    </div>

                    <div class="form-container">
                        <form id="exchange-form" action="" method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="nom">Nom de l'objet</label>
                                <input type="text" id="nom" name="nom" placeholder="Ajouter le nom de l'objet" class="form-input" required>
                            </div>

                            <div class="form-row-3">
                                <div class="form-group">
                                    <label for="categorie">Catégorie</label>
                                    <select id="categorie" name="categorie" class="form-input" required>
                                        <option value="" disabled selected>choisir la catégorie</option>
                                        <option value="Mobilier">Mobilier</option>
                                        <option value="Électronique">Électronique</option>
                                        <option value="Fournitures">Fournitures</option>
                                        <option value="Sport">Sport</option>
                                        <option value="Outils">Outils</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="etat">État</label>
                                    <select id="etat" name="etat" class="form-input" required>
                                        <option value="" disabled selected>choisir l'état</option>
                                        <option value="neuf">Neuf</option>
                                        <option value="bon">Bon état</option>
                                        <option value="use">Usagé</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="quantite">Quantité</label>
                                    <input type="number" id="quantite" name="quantite" placeholder="Ajouter une quantité" class="form-input" min="1" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" placeholder="Ajouter une description" class="form-textarea" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Ajouter une photo</label>
                                <div class="upload-box">
                                    <input type="file" id="photo" name="photo" class="file-input" required>
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
                </section>
            </div>
        </div>

        <?php View::render('footer'); ?>

    </main>

    <script>
    // Préremplir le formulaire depuis une carte de réservation
    document.querySelectorAll('.reservation-card .btn-select').forEach((btn) => {
        btn.addEventListener('click', () => {
            const card = btn.closest('.reservation-card');
            if (!card) return;

            const nom = card.dataset.nom || '';
            const description = card.dataset.description || '';
            const quantite = card.dataset.quantite || '';

            const form = document.getElementById('exchange-form');
            if (!form) return;

            form.querySelector('#nom').value = nom;
            form.querySelector('#description').value = description;
            form.querySelector('#quantite').value = quantite;

            const title = document.querySelector('.page-title');
            (title || form).scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    // Afficher confirmation lors de l'envoi du formulaire
    const form = document.getElementById('exchange-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Empêche l'envoi réel tant que le back n'est pas câblé

            const confirmBox = document.getElementById('form-confirmation');
            const errorBox = document.getElementById('form-error');

            const nom = form.querySelector('#nom')?.value.trim();
            const cat = form.querySelector('#categorie')?.value;
            const etat = form.querySelector('#etat')?.value;
            const qte = form.querySelector('#quantite')?.value;
            const desc = form.querySelector('#description')?.value.trim();
            const photo = form.querySelector('#photo');

            const photoOk = photo && photo.files && photo.files.length > 0;
            const allFilled = nom && cat && etat && qte && Number(qte) > 0 && desc && photoOk;

            if (!allFilled) {
                if (errorBox) errorBox.style.display = 'block';
                if (confirmBox) confirmBox.style.display = 'none';
                return;
            }

            if (errorBox) errorBox.style.display = 'none';
            if (confirmBox) confirmBox.style.display = 'block';
        });
    }
    </script>
</body>

</html>