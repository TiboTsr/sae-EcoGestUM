<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <link rel="stylesheet" href="assets/css/etu/etuCampagne.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <div class="app-container">
        <div class="sidebar-container">
            <?php View::render('sideBar'); ?>
        </div>

        <main class="main-content">
            <div class="hero-banner">
                <img src="images/banner.jpg" alt="Bannière" class="hero-image">
            </div>

            <div class="content-wrapper">
                <h1 class="page-title">Campagnes</h1>

                <div class="layout-grid">

                    <div class="campaigns-list">
                        <?php if (empty($data['campagnes'])): ?>
                            <p style="padding:20px;">Aucune campagne en cours.</p>
                        <?php else: ?>
                            <?php foreach ($data['campagnes'] as $camp): ?>
                                <?php $isInscrit = in_array($camp['id_camp'], $data['mesInscriptions'] ?? []); ?>

                                <article class="campaign-card" id="camp-date-<?= date('Y-m-d', strtotime($camp['date_pub_camp'])) ?>">
                                    <div class="camp-img">
                                        <img src="assets/img/campagne_default.jpg" alt="Campagne">
                                    </div>
                                    <div class="camp-content">
                                        <h2><?= htmlspecialchars($camp['titre_camp']) ?></h2>
                                        <p class="camp-desc"><?= htmlspecialchars($camp['contenu_camp']) ?></p>

                                        <div class="camp-footer">
                                            <span class="camp-date">
                                                <i class="far fa-calendar-alt"></i>
                                                <?= date('d/m/Y', strtotime($camp['date_pub_camp'])) ?>
                                            </span>

                                            <?php if ($isInscrit): ?>
                                                <button type="button" class="btn-unsubscribe"
                                                    onclick="openUnsubscribeModal(<?= $camp['id_camp'] ?>, '<?= addslashes(htmlspecialchars($camp['titre_camp'], ENT_QUOTES)) ?>')">
                                                    <span><i class="fas fa-check"></i> Inscrit</span>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn-subscribe"
                                                    onclick="openConfirmModal(<?= $camp['id_camp'] ?>, '<?= addslashes(htmlspecialchars($camp['titre_camp'], ENT_QUOTES)) ?>')">
                                                    S'inscrire
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <div class="calendar-wrapper">
                        <h3>Calendrier</h3>
                        <div class="calendar-card">
                            <div class="calendar-header">
                                <span id="month-year"></span>
                            </div>
                            <div class="calendar-body">
                                <div class="calendar-weekdays">
                                    <div>LUN</div>
                                    <div>MAR</div>
                                    <div>MER</div>
                                    <div>JEU</div>
                                    <div>VEN</div>
                                    <div>SAM</div>
                                    <div>DIM</div>
                                </div>
                                <div class="calendar-days" id="calendar-days">
                                </div>
                            </div>
                        </div>
                        <div class="calendar-nav">
                            <button onclick="changeMonth(-1)"><i class="fas fa-chevron-left"></i></button>
                            <button onclick="changeMonth(1)"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                </div>
            </div>
            <?php View::render('footer'); ?>
        </main>
    </div>

    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirmation</h2>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment vous inscrire à :</p>
                <h3 id="modal-camp-title" style="color: #2A3A6D; margin: 10px 0;"></h3>

                <form action="index.php?page=EtuCampagne&action=inscrire" method="POST">
                    <input type="hidden" name="id_camp" id="modal-camp-id" value="">
                    <div class="modal-buttons">
                        <button type="button" class="btn-modal-cancel" onclick="closeModal('confirmModal')">Annuler</button>
                        <button type="submit" class="btn-modal-confirm">Je m'inscris</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="unsubscribeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 style="color: #e74c3c;">Se désinscrire ?</h2>
            </div>
            <div class="modal-body">
                <p>Vous êtes déjà inscrit à :</p>
                <h3 id="unsub-camp-title" style="color: #333; margin: 10px 0;"></h3>
                <p style="font-size:0.9rem; color:#666;">Souhaitez-vous annuler votre participation ?</p>

                <form action="index.php?page=EtuCampagne&action=desinscrire" method="POST">
                    <input type="hidden" name="id_camp" id="unsub-camp-id" value="">
                    <div class="modal-buttons">
                        <button type="button" class="btn-modal-cancel" onclick="closeModal('unsubscribeModal')">Garder</button>
                        <button type="submit" class="btn-modal-danger">Se désinscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openConfirmModal(id, title) {
            document.getElementById('modal-camp-id').value = id;
            document.getElementById('modal-camp-title').innerText = title;
            document.getElementById('confirmModal').style.display = 'block';
        }

        function openUnsubscribeModal(id, title) {
            document.getElementById('unsub-camp-id').value = id;
            document.getElementById('unsub-camp-title').innerText = title;
            document.getElementById('unsubscribeModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        const campaignDates = [
            <?php
            foreach ($data['campagnes'] as $c) {
                echo "'" . date('Y-m-d', strtotime($c['date_pub_camp'])) . "',";
            }
            ?>
        ];

        let currentDate = new Date();

        function renderCalendar() {
            const monthYear = document.getElementById('month-year');
            const daysContainer = document.getElementById('calendar-days');

            const month = currentDate.getMonth();
            const year = currentDate.getFullYear();

            const monthNames = ["JANVIER", "FÉVRIER", "MARS", "AVRIL", "MAI", "JUIN", "JUILLET", "AOÛT", "SEPTEMBRE", "OCTOBRE", "NOVEMBRE", "DÉCEMBRE"];
            monthYear.innerText = `${monthNames[month]} ${year}`;

            const firstDayOfMonth = new Date(year, month, 1).getDay();
            const startDay = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            daysContainer.innerHTML = "";

            for (let i = 0; i < startDay; i++) {
                daysContainer.innerHTML += `<div class="empty"></div>`;
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;

                let dayHTML = `<div class="day" onclick="scrollToDate('${dateString}')">
                                ${i}`;

                if (campaignDates.includes(dateString)) {
                    dayHTML += `<span class="event-dot"></span>`;
                }

                dayHTML += `</div>`;
                daysContainer.innerHTML += dayHTML;
            }
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        function scrollToDate(dateStr) {
            const element = document.getElementById('camp-date-' + dateStr);
            const container = document.querySelector('.campaigns-list');

            if (element && container) {
                const topPos = element.offsetTop - container.offsetTop;
                container.scrollTo({
                    top: topPos,
                    behavior: 'smooth'
                });
                element.style.borderColor = "#2A3A6D";
                setTimeout(() => element.style.borderColor = "#e1e1e1", 1500);
            }
        }

        renderCalendar();
    </script>
</body>

</html>