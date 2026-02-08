<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="assets/css/sideBar.css">
    <link rel="stylesheet" href="assets/css/chefDep/chefDepTabDeBord.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php View::render('sidebar'); ?>

    <div class="hero-banner">
        <img src="images/unsplash_dqXiw7nCb9Q.png" alt="Bannière">
    </div>

    <main class="main-content">
        <div class="page-header-container">
            <h1 class="page-title">Suivi de l'impact environnemental</h1>
        </div>

        <div class="dashboard-grid">
            <div class="left-column">
                <div class="card card-accent-top">
                    <h3>Répartition des matériaux</h3>
                    
                    <div class="legend-grid">
                        <?php 
                        // Palette de couleurs identique au JS
                        $colors = ['#F5B7B1', '#AED6F1', '#F9E79F', '#ABEBC6', '#D2B4DE'];
                        if (!empty($repartitionData)):
                            foreach($repartitionData as $index => $row): 
                                // On assigne une couleur en boucle
                                $color = $colors[$index % count($colors)]; 
                        ?>
                            <div class="legend-item">
                                <span class="dot" style="background-color: <?= $color ?>;"></span>
                                <?= htmlspecialchars($row['nom_cat']) ?>
                            </div>
                        <?php 
                            endforeach;
                        else: 
                        ?>
                            <p>Aucune donnée disponible.</p>
                        <?php endif; ?>
                    </div>
                    <div class="donut-wrapper">
                        <canvas id="repartitionChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="right-column">
                <div class="kpi-row">
                    <div class="card card-accent-left">
                        <h3>Economie réalisée</h3>
                        <div class="kpi-value"><?= number_format($economie, 0, ',', ' ') ?> €</div>
                    </div>
                    <div class="card card-accent-left">
                        <div class="icon-recycle">♻</div>
                        <h3><?= $poids ?>T</h3>
                        <p>de matériaux recyclé</p>
                    </div>
                    <div class="card card-accent-left">
                        <h3>Taux de réutilisation</h3>
                        <div class="gauge-wrapper">
                            <div class="gauge-arc" style="--p:<?= $taux ?>">
                                <div class="gauge-text"><?= $taux ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-accent-left chart-section">
                    <div class="chart-header">
                        <h3>Bilan carbone du laboratoire</h3>
                        <select class="chart-select">
                            <option>à l'année</option>
                        </select>
                    </div>
                    <div class="line-chart-wrapper">
                        <canvas id="carbonChart"></canvas>
                    </div>
                    <div class="bottom-stats">
                        <div class="stat-item">
                            <span class="label">Meilleur Mois</span>
                            <span class="value blue">Novembre</span>
                            <span class="sub">2019</span>
                        </div>
                        <div class="stat-item">
                            <span class="label">Meilleur Année</span>
                            <span class="value blue">2023</span>
                            <span class="sub danger">96t CO2 de reduction</span>
                        </div>
                        <div class="stat-item">
                            <span class="label">Meilleur Recycleur</span>
                            <?php if($topRecycleur): ?>
                                <div class="recycler-info">
                                    <div class="recycler-dot"></div>
                                    <div>
                                        <strong><?= htmlspecialchars($topRecycleur['nom_user']) ?></strong>
                                        <br><small><?= htmlspecialchars($topRecycleur['mail_user']) ?></small>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span>Aucune donnée</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <?php View::render('footer'); ?>
    </main>

    <script>
        const ctxLine = document.getElementById('carbonChart').getContext('2d');
        const labelsLine = <?= $jsonLabelsLine ?>.length ? <?= $jsonLabelsLine ?> : ['2016', '2017', '2018', '2019', '2020'];
        const dataLine = <?= $jsonDataLine ?>.length ? <?= $jsonDataLine ?> : [10, 20, 45, 30, 60];

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labelsLine,
                datasets: [{
                    label: 'CO2',
                    data: dataLine,
                    borderColor: '#82E0AA',
                    backgroundColor: 'rgba(130, 224, 170, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });

        const ctxDonut = document.getElementById('repartitionChart').getContext('2d');
        const labelsDonut = <?= $jsonLabelsDonut ?>.length ? <?= $jsonLabelsDonut ?> : ['Vide'];
        const dataDonut = <?= $jsonDataDonut ?>.length ? <?= $jsonDataDonut ?> : [1];

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: labelsDonut,
                datasets: [{
                    data: dataDonut,
                    // Mêmes couleurs que dans le PHP ci-dessus
                    backgroundColor: ['#F5B7B1', '#AED6F1', '#F9E79F', '#ABEBC6', '#D2B4DE'],
                    borderWidth: 0,
                    hoverOffset: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                events: [],
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>