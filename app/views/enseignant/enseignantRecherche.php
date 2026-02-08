<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($data['title'] ?? "Recherche et Réservation") ?></title>
    <link rel="stylesheet" href="assets/css/enseignant/enseignantRecherche.css" />
</head>

<body>

    <div class="app-container">
        <div class="sidebar-container">
            <?php View::render('sideBar'); ?>
        </div>

        <main class="main-content">

            <div class="hero-banner-container">
                <img src="images/banner.jpg"
                    alt="Campus Le Mans Université"
                    class="hero-image">
            </div>

            <div class="content-wrapper">
                <h1 class="page-title">Recherche et réservation</h1>
                <form method="GET" action="index.php">
                    <input type="hidden" name="page" value="enseignantRecherche"> <input type="hidden" name="action" value="index">

                    <div class="top-actions">
                            <button type="button" class="btn btn-primary" onclick="openMyResModal()">Voir mes réservations</button>

                        <input type="text" name="search" class="search-input" placeholder="Saisir ici..." value="<?= htmlspecialchars($data['search_term'] ?? '') ?>">

                        <button type="submit" class="btn btn-primary">Rechercher</button>
                    </div>

                    <div class="content-grid">

                        <aside class="filters-panel">

                            <div class="filter-section">
                                <span class="filter-title">Catégorie</span>
                                <div class="checkbox-group">
                                    <label><input type="checkbox" name="cat[]" value="Informatique" <?= (isset($data['filtres_cat']) && in_array('Informatique', $data['filtres_cat'])) ? 'checked' : '' ?>> Informatique</label>
                                    <label><input type="checkbox" name="cat[]" value="Mobilier" <?= (isset($data['filtres_cat']) && in_array('Mobilier', $data['filtres_cat'])) ? 'checked' : '' ?>> Mobilier</label>
                                    <label><input type="checkbox" name="cat[]" value="Papeterie" <?= (isset($data['filtres_cat']) && in_array('Papeterie', $data['filtres_cat'])) ? 'checked' : '' ?>> Papeterie</label>
                                </div>
                            </div>

                            <div class="filter-section">
                                <span class="filter-title">État</span>
                                <div class="checkbox-group">
                                    <label><input type="checkbox" name="etat[]" value="Neuf" <?= (isset($data['filtres_etat']) && in_array('Neuf', $data['filtres_etat'])) ? 'checked' : '' ?>> Neuf</label>
                                    <label><input type="checkbox" name="etat[]" value="A_reparer" <?= (isset($data['filtres_etat']) && in_array('A_reparer', $data['filtres_etat'])) ? 'checked' : '' ?>> À réparer</label>
                                    <label><input type="checkbox" name="etat[]" value="Recyclable" <?= (isset($data['filtres_etat']) && in_array('Recyclable', $data['filtres_etat'])) ? 'checked' : '' ?>> Récyclable</label>
                                    <label><input type="checkbox" name="etat[]" value="Label_A" <?= (isset($data['filtres_etat']) && in_array('Label_A', $data['filtres_etat'])) ? 'checked' : '' ?>> Label</label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:10px;">Filtrer</button>
                        </aside>

                        <section class="results-area">
                            <?php if (empty($data['objets'])): ?>
                                <p style="padding: 20px;">Aucun objet trouvé.</p>
                            <?php else: ?>
                                <?php foreach ($data['objets'] as $objet): ?>
                                    <article class="card-objet">
                                        <div class="card-img-container">
                                            <img src="<?= htmlspecialchars($objet['image_url'] ?? 'assets/img/default.jpg') ?>" alt="<?= htmlspecialchars($objet['nom_obj']) ?>">
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title"><?= htmlspecialchars($objet['nom_obj']) ?></h3>

                                            <div style="color: #27ae60; font-weight: bold; margin-bottom: 5px;">
                                                Quantité : <?= htmlspecialchars($objet['quantite_obj']) ?>
                                            </div>

                                            <p class="card-desc"><?= htmlspecialchars($objet['description_obj']) ?></p>

                                            <div class="card-meta">
                                                <div><span class="meta-label">Cat :</span> <?= htmlspecialchars($objet['nom_cat']) ?></div>
                                                <div><span class="meta-label">Etat :</span> <?= htmlspecialchars($objet['etat_obj_']) ?></div>
                                                <div><span class="meta-label">Lieu :</span> <?= htmlspecialchars($objet['nom_pc']) ?></div>
                                            </div>

                                            <button type="button" class="btn-reserve"
                                                onclick="openModal(<?= $objet['id_obj'] ?>, '<?= addslashes(htmlspecialchars($objet['nom_obj'], ENT_QUOTES)) ?>', <?= $objet['quantite_obj'] ?>)">
                                                Réserver
                                            </button>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </section>

                    </div>
                </form>
            </div>

            <?php View::render('footer'); ?>
        </main>
    </div>

    <!-- Toast container -->
    <div id="toast" style="position:fixed; right:20px; bottom:20px; z-index:3000; display:none;">
        <div id="toast-inner" style="background:#2A3A6D; color:#fff; padding:14px 18px; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.2);"></div>
    </div>

    <div id="myResModal" class="modal">
        <div class="modal-content modal-large">
            <div class="modal-header">
                <h2>Mes Réservations</h2>
            </div>
            <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                <?php if (empty($data['reservations'])): ?>
                    <p style="padding:20px; color:#666;">Vous n'avez aucune réservation en cours.</p>
                <?php else: ?>
                    <table class="res-table">
                        <thead>
                            <tr>
                                <th>Objet</th>
                                <th>Date</th>
                                <th>Qté</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['reservations'] as $res): ?>
                                <tr>
                                    <td style="font-weight:bold; color:#2A3A6D;"><?= htmlspecialchars($res['nom_obj'] ?? $res['nom']) ?></td>
                                    <td><?= isset($res['date_res']) ? date('d/m/Y', strtotime($res['date_res'])) : '' ?></td>
                                    <td><?= htmlspecialchars($res['qte_res'] ?? $res['qte'] ?? '') ?></td>
                                    <td>
                                        <?php 
                                            $s = $res['statut_res'] ?? $res['statut'] ?? 'En attente';
                                            $cls = 'bg-attente';
                                            if(stripos($s, 'ann')!==false || stripos($s, 'refus')!==false) $cls='bg-annulee';
                                            elseif(stripos($s, 'conf')!==false || stripos($s, 'valid')!==false) $cls='bg-validee';
                                            elseif(stripos($s, 'term')!==false) $cls='bg-terminee';
                                        ?>
                                        <span class="badge <?= $cls ?>"><?= htmlspecialchars($s) ?></span>
                                    </td>
                                    <td>
                                        <?php if(stripos(strtolower($s), 'attente') !== false || stripos(strtolower($s), 'en attente') !== false): ?>
                                            <form action="index.php?page=enseignantRecherche&action=annuler" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                                <input type="hidden" name="id_res" value="<?= htmlspecialchars($res['id_res']) ?>">
                                                <button type="submit" style="color:#e74c3c; background:none; border:none; cursor:pointer; text-decoration:underline; font-size:0.9rem;">Annuler</button>
                                            </form>
                                        <?php else: ?>
                                            <span style="color:#aaa; font-size:0.8rem;">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
                
                <div class="modal-buttons" style="margin-top:20px; justify-content:center;">
                    <button type="button" class="btn btn-cancel" onclick="closeMyResModal()">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div id="reservationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirmation</h2>
            </div>
            <div class="modal-body">
                <p>Réserver l'objet : <strong id="modal-nom-objet" style="color:#2A3A6D;"></strong></p>

                <form action="index.php?page=enseignantRecherche&action=reserver" method="POST"> <input type="hidden" name="id_obj" id="modal-id-objet" value="">

                    <div style="margin: 15px 0; text-align: left;">
                        <label>Quantité souhaitée (Max: <span id="modal-max-qty"></span>) :</label>
                        <input type="number" name="quantite" id="modal-quantite"
                            min="1" max="" required value="1"
                            style="width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:5px;">
                    </div>

                    <div style="margin: 15px 0; text-align: left;">
                        <label>Motif de l'emprunt :</label>
                        <input type="text" name="usage" required placeholder="Ex: Projet S3"
                            style="width:100%; padding:10px; margin-top:5px; border:1px solid #ccc; border-radius:5px;">
                    </div>

                    <div class="modal-buttons">
                        <button type="button" class="btn btn-cancel" onclick="closeModal()">Annuler</button>
                        <button type="submit" class="btn btn-confirm">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show toast if redirected after reservation
        (function(){
            const params = new URLSearchParams(window.location.search);
            if(params.get('success') === '1'){
                showToast('Réservation confirmée', true);
                // remove querystring to avoid repeated toast on reload
                history.replaceState(null, '', window.location.pathname + window.location.search.replace(/(\?|&)success=1(&|$)/, '$1').replace(/(\?|&)error=[^&]*/,'').replace(/\?$/,''));
            } else if(params.get('success') === '0'){
                const err = params.get('error') || 'unknown';
                if(err === 'stock') showToast('Erreur : stock insuffisant', false);
                else if(err === 'invalid') showToast('Erreur : données invalides', false);
                else showToast('Erreur lors de la réservation', false);
                history.replaceState(null, '', window.location.pathname + window.location.search.replace(/(\?|&)success=0(&|$)/, '$1').replace(/(\?|&)error=[^&]*/,'').replace(/\?$/,''));
            }
        })();

        function openModal(id, nom, maxQty) {
            document.getElementById('modal-id-objet').value = id;
            document.getElementById('modal-nom-objet').innerText = nom;

            var qtyInput = document.getElementById('modal-quantite');
            qtyInput.max = maxQty;
            qtyInput.value = 1;
            document.getElementById('modal-max-qty').innerText = maxQty;

            document.getElementById('reservationModal').style.display = 'block';
        }

        function showToast(message, success){
            const toast = document.getElementById('toast');
            const inner = document.getElementById('toast-inner');
            inner.textContent = message;
            inner.style.background = success ? '#2ecc71' : '#e74c3c';
            toast.style.display = 'block';
            setTimeout(()=>{ toast.style.opacity = '1'; }, 50);
            setTimeout(()=>{ toast.style.opacity = '0'; setTimeout(()=> toast.style.display='none',400); }, 3500);
        }

        function closeModal() { document.getElementById('reservationModal').style.display = 'none'; }

        function openMyResModal() { document.getElementById('myResModal').style.display = 'block'; }
        function closeMyResModal() { document.getElementById('myResModal').style.display = 'none'; }

        window.onclick = function(event) {
            if (event.target == document.getElementById('reservationModal')) closeModal();
            if (event.target == document.getElementById('myResModal')) closeMyResModal();
        }
    </script>
</body>

</html>
