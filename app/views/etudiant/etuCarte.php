<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title'] ?? 'Carte des Dépôts') ?></title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="assets/css/etu/etuCarte.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>

    <div class="app-container">
        <div class="sidebar-container">
            <?php View::render('sideBar'); ?>
        </div>

        <main class="main-content no-padding">
            <div class="map-layout">

                <div class="map-sidebar">
                    <div class="search-header">
                        <div class="search-bar-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" id="search-input" placeholder="Rechercher (Nom, Ville...)">
                        </div>
                    </div>

                    <div class="locations-list" id="locations-list">
                        <?php if (isset($data['points']) && !empty($data['points'])): ?>
                            <?php foreach ($data['points'] as $pc): ?>
                                <div id="card-<?= $pc['id_pc'] ?>" class="location-card" onclick="focusOnMap(this, <?= $pc['id_pc'] ?>, <?= $pc['latitude'] ?>, <?= $pc['longitude'] ?>)">
                                    <h3 class="loc-name"><?= htmlspecialchars($pc['nom_pc']) ?></h3>
                                    <p class="loc-address"><?= htmlspecialchars($pc['adresse_pc']) ?></p>
                                    <span class="loc-distance">Cliquez pour voir</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div style="padding:20px;">Aucun point trouvé.</div>
                        <?php endif; ?>

                        <div id="no-results" style="display:none; padding:20px; text-align:center;">
                            Aucun résultat ne correspond à votre recherche.
                        </div>
                    </div>
                </div>

                <div id="map"></div>

            </div>
        </main>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        var pointsData = <?= json_encode($data['points'] ?? []) ?>;

        var map = L.map('map');

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);


        var blackIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-black.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var redIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var markersGroup = new L.FeatureGroup();

        function displayMarkers(pointsToDisplay) {
            markersGroup.clearLayers();

            pointsToDisplay.forEach(function(point) {
                if (point.latitude && point.longitude) {
                    var marker = L.marker([point.latitude, point.longitude], {
                            icon: blackIcon
                        })
                        .bindPopup("<b>" + point.nom_pc + "</b><br>" + point.adresse_pc);

                    marker.pointId = point.id_pc;

                    marker.on('click', function() {
                        var cardElement = document.getElementById('card-' + point.id_pc);
                        focusOnMap(cardElement, point.id_pc, point.latitude, point.longitude);
                        if (cardElement) {
                            cardElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    });

                    markersGroup.addLayer(marker);
                }
            });

            if (markersGroup.getLayers().length > 0) {
                map.fitBounds(markersGroup.getBounds(), {
                    padding: [50, 50]
                });
            }
        }

        map.addLayer(markersGroup);
        displayMarkers(pointsData);


        function focusOnMap(element, id, lat, lng) {
            document.querySelectorAll('.location-card').forEach(function(card) {
                card.classList.remove('active');
            });
            if (element) {
                element.classList.add('active');
            }

            if (lat && lng) {
                map.flyTo([lat, lng], 16);

                markersGroup.eachLayer(function(layer) {
                    if (layer.pointId == id) {
                        layer.setIcon(redIcon);
                        layer.openPopup();
                    } else {
                        layer.setIcon(blackIcon);
                    }
                });
            }
        }

        document.getElementById('search-input').addEventListener('input', function(e) {
            var searchTerm = e.target.value.toLowerCase();
            var noResults = document.getElementById('no-results');
            var hasVisiblePoints = false;

            var filteredPoints = pointsData.filter(function(point) {
                var match = point.nom_pc.toLowerCase().includes(searchTerm) ||
                    point.adresse_pc.toLowerCase().includes(searchTerm);

                var card = document.getElementById('card-' + point.id_pc);
                if (card) {
                    if (match) {
                        card.style.display = 'block';
                        hasVisiblePoints = true;
                    } else {
                        card.style.display = 'none';
                    }
                }
                return match;
            });

            displayMarkers(filteredPoints);

            if (!hasVisiblePoints) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    </script>
</body>

</html>