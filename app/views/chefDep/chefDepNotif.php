<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Notifications') ?></title>
    <link rel="stylesheet" href="assets/css/chefDep/chepDepInv.css">
    <link rel="stylesheet" href="assets/css/chefDep/chefDepNotif.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php View::render('sidebar'); ?>

    <main class="main-content">

        <div class="hero-banner">
            <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière">
        </div>

        <div class="page-container">

            <div class="header-wrapper">
                <h1 class="page-title">Envoyer une notification</h1>
                <h2 class="history-title-mobile">Historiques des notifications</h2>
            </div>
            
            <?php if (!empty($message)): ?>
                <div class="alert" style="padding: 15px; margin-bottom: 20px; border-radius: 5px; background-color: <?= $message_type == 'success' ? '#d4edda' : '#f8d7da' ?>; color: <?= $message_type == 'success' ? '#155724' : '#721c24' ?>;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <div class="content-wrapper"> 
                
                <div class="form-container">
                    <form action="" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="destinataires">Destinataire(s)</label>
                            <input type="text" id="destinataires" name="destinataires" value="Enseignants & Étudiants" readonly class="form-input" style="background-color: #e9ecef; cursor: not-allowed;">
                        </div>

                        <div class="form-group">
                            <label for="objet">Objet</label>
                            <input type="text" id="objet" name="objet" placeholder="Saisir ici..." class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Saisir ici..." class="form-textarea" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pièces Jointes</label>
                            <div class="upload-box">
                                <input type="file" id="photo" name="photo" class="file-input">
                                <p class="upload-hint">Cliquer ou Glisser/Déposer</p>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-submit">Envoyer</button>
                        </div>
                    </form>
                </div>
                
                <div class="notifications-history">
                    <?php if (!empty($historique)): ?>
                        <?php foreach ($historique as $notif): ?>
                            <?php 
                                $fullMessage = $notif['mess_not'];
                                $displayTitle = 'Notification';
                                $displayText = $fullMessage;

                                if (preg_match('/^\[Objet: (.*?)\] (.*)$/', $fullMessage, $matches)) {
                                    $displayTitle = $matches[1];
                                    $displayText = $matches[2];
                                }
                            ?>
                            <div class="notification-card">
                                <h3 class="card-title"><?= htmlspecialchars($displayTitle) ?></h3>
                                <p class="card-text">
                                    <?= htmlspecialchars($displayText) ?>
                                </p>
                                <small style="display:block; margin-top:10px; color:#666;">
                                    Envoyé le : <?= date('d/m/Y H:i', strtotime($notif['date_not'])) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune notification récente.</p>
                    <?php endif; ?>
                </div>
            </div> 
        </div>

        <?php View::render('footer'); ?>

    </main>
</body>
</html>
