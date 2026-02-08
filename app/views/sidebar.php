<link rel="stylesheet" href="assets/css/sideBar.css">

<?php
// 1. Initialisation et récupération de la page courante
$currentPage = isset($_GET['page']) ? $_GET['page'] : '';

// Démarrage de la session si nécessaire
if (session_status() === PHP_SESSION_NONE) session_start();

// 2. Récupération des données utilisateur depuis la session
$user        = $_SESSION['user'] ?? [];
$id_role     = $user['id_role'] ?? 0; // 0 = Visiteur/Non connecté
$nom_role    = $user['nom_role'] ?? 'Visiteur';
$prenom_user = $user['prenom_user'] ?? 'Invité';
$nom_user    = $user['nom_user'] ?? '';
$mail_user   = $user['mail_user'] ?? 'Non connecté';

// 3. Définition des menus par rôle
// Structure : [ 'page', 'label', 'viewBox' (optionnel, défaut 24 24), 'icon' ]

// --- MENU CHEF DE DÉPARTEMENT (ID = 1) ---
$menuChef = [
    [
        'page' => 'chefDepInv', 
        'label' => 'Inventaire', 
        'viewBox' => '0 0 24 24',
        'icon' => '<g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M14.071 2.887l4.786 2.762a4.14 4.14 0 0 1 2.071 3.588v5.526c0 1.48-.79 2.848-2.071 3.588l-4.786 2.762a4.14 4.14 0 0 1-4.142 0l-4.786-2.762a4.14 4.14 0 0 1-2.071-3.588V9.237c0-1.48.79-2.848 2.071-3.588L9.93 2.887a4.14 4.14 0 0 1 4.142 0Zm-1 1.732a2.14 2.14 0 0 0-2.142 0L6.143 7.38a2.14 2.14 0 0 0-1.071 1.856v5.526c0 .765.408 1.473 1.071 1.856l4.786 2.762a2.14 2.14 0 0 0 2.142 0l4.786-2.762a2.14 2.14 0 0 0 1.071-1.856V9.237c0-.765-.408-1.473-1.071-1.856L13.07 4.62Z"/><path d="M10.595 11.844l-5.9-2.95l.895-1.788l5.899 2.949c.322.16.7.16 1.022 0l5.899-2.95l.895 1.79l-5.9 2.949a3.14 3.14 0 0 1-2.81 0"/><path d="M13 11.428v9.143h-2v-9.143zM7.677 5.267a1 1 0 0 1 1.342-.447l6.857 3.428a1 1 0 1 1-.895 1.79l-6.857-3.43a1 1 0 0 1-.447-1.34Z"/></g>'
    ],
    [
        'page' => 'chefDepAddObj', 
        'label' => 'Proposer un objet', 
        'viewBox' => '0 0 24 24',
        'icon' => '<path fill="currentColor" d="M19 12.998h-6v6h-2v-6H5v-2h6v-6h2v6h6z"/>'
    ],
    [
        'page' => 'chefDepHisto', 
        'label' => 'Historique', 
        'viewBox' => '0 0 24 24',
        'icon' => '<g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M10.5 14H17M7 14h.5M7 10.5h.5m-.5 7h.5m3-7H17m-6.5 7H17"/><path d="M8 3.5A1.5 1.5 0 0 1 9.5 2h5A1.5 1.5 0 0 1 16 3.5v1A1.5 1.5 0 0 1 14.5 6h-5A1.5 1.5 0 0 1 8 4.5z"/><path stroke-linecap="round" d="M21 16c0 2.829 0 4.243-.879 5.122C19.243 22 17.828 22 15 22H9c-2.828 0-4.243 0-5.121-.878C3 20.242 3 18.829 3 16v-3m13-8.998c2.175.012 3.353.109 4.121.877C21 5.758 21 7.172 21 10v2M8 4.002c-2.175.012-3.353.109-4.121.877S3.014 6.825 3.002 9"/></g>'
    ],
    [
        'page' => 'chefDepNotif', 
        'label' => 'Notifications', 
        'viewBox' => '0 0 1024 1024',
        'icon' => '<path fill="currentColor" d="M880 112c-3.8 0-7.7.7-11.6 2.3L292 345.9H128c-8.8 0-16 7.4-16 16.6v299c0 9.2 7.2 16.6 16 16.6h101.7c-3.7 11.6-5.7 23.9-5.7 36.4c0 65.9 53.8 119.5 120 119.5c55.4 0 102.1-37.6 115.9-88.4l408.6 164.2c3.9 1.5 7.8 2.3 11.6 2.3c16.9 0 32-14.2 32-33.2V145.2C912 126.2 897 112 880 112M344 762.3c-26.5 0-48-21.4-48-47.8c0-11.2 3.9-21.9 11-30.4l84.9 34.1c-2 24.6-22.7 44.1-47.9 44.1m496 58.4L318.8 611.3l-12.9-5.2H184V417.9h121.9l12.9-5.2L840 203.3z"/>'
    ],
    [
        'page' => 'chefDepCollab', 
        'label' => 'Collaboration', 
        'viewBox' => '0 0 576 512',
        'icon' => '<path fill="currentColor" d="M268.9 53.2L152.3 182.8c-4.6 5.1-4.4 13 .5 17.9c30.5 30.5 80 30.5 110.5 0l31.8-31.8c4.2-4.2 9.5-6.5 14.9-6.9c6.8-.6 13.8 1.7 19 6.9L505.6 344l70.4-56V0L464 64l-23.8-15.9A96.2 96.2 0 0 0 386.9 32h-70.4c-1.1 0-2.3 0-3.4.1c-16.9.9-32.8 8.5-44.2 21.1m-152.3 97.5L223.4 32h-39.6c-25.5 0-49.9 10.1-67.9 28.1L0 192v352l144-136l12.4 10.3c23 19.2 52 29.7 81.9 29.7H254l-7-7c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l41 41h9c19.1 0 37.8-4.3 54.8-12.3L359 409c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l32 32l17.5-17.5c8.9-8.9 11.5-21.8 7.6-33.1L312.1 219.7l-14.9 14.9c-49.3 49.3-129.1 49.3-178.4 0c-23-23-23.9-59.9-2.2-84z"/>'
    ],
    [
        'page' => 'chefDepTabDeBord', 
        'label' => 'Tableau de bord', 
        'viewBox' => '0 0 512 512',
        'icon' => '<path fill="currentColor" d="M104 496H72a24 24 0 0 1-24-24V328a24 24 0 0 1 24-24h32a24 24 0 0 1 24 24v144a24 24 0 0 1-24 24m224 0h-32a24 24 0 0 1-24-24V232a24 24 0 0 1 24-24h32a24 24 0 0 1 24 24v240a24 24 0 0 1-24 24m112 0h-32a24 24 0 0 1-24-24V120a24 24 0 0 1 24-24h32a24 24 0 0 1 24 24v352a24 24 0 0 1-24 24m-224 0h-32a24 24 0 0 1-24-24V40a24 24 0 0 1 24-24h32a24 24 0 0 1 24-24v432a24 24 0 0 1-24 24"/>'
    ]
];

// --- MENU ÉTUDIANT (ID = 2) ---
$menuEtu = [
    [
        'page' => 'etuRechEtRes',
        'label' => 'Rechercher & Réserver',
        'viewBox' => '0 0 24 24',
        'icon' => '<circle cx="11" cy="11" r="8" fill="none" stroke="currentColor" stroke-width="2"/><line x1="21" y1="21" x2="16.65" y2="16.65" fill="none" stroke="currentColor" stroke-width="2"/>'
    ],
    [
        'page' => 'etuSignaler',
        'label' => 'Signaler un objet',
        'viewBox' => '0 0 24 24',
        'icon' => '<path d="M16 12V4H17V2H7V4H8V12L6 14V16H11V22H13V16H18V14L16 12Z" fill="currentColor"/>'
    ],
    [
        'page' => 'etuProp',
        'label' => 'Proposer un objet',
        'viewBox' => '0 0 24 24',
        'icon' => '<line x1="12" y1="5" x2="12" y2="19" fill="none" stroke="currentColor" stroke-width="2"></line><line x1="5" y1="12" x2="19" y2="12" fill="none" stroke="currentColor" stroke-width="2"></line>'
    ],
    [
        'page' => 'etuCarte',
        'label' => 'Carte',
        'viewBox' => '0 0 24 24',
        'icon' => '<path d="M1 6v16l7-4 8 4 7-4V2l-7 4-8-4-7 4z" fill="none" stroke="currentColor" stroke-width="2"></path><line x1="8" y1="2" x2="8" y2="18" fill="none" stroke="currentColor" stroke-width="2"></line><line x1="16" y1="6" x2="16" y2="22" fill="none" stroke="currentColor" stroke-width="2"></line>'
    ],
    [
        'page' => 'etuEchange',
        'label' => 'Echange matériel',
        'viewBox' => '0 0 24 24',
        'icon' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>'
    ],
    [
        'page' => 'etuCampagne',
        'label' => 'Campagne',
        'viewBox' => '0 0 24 24',
        'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" fill="none" stroke="currentColor" stroke-width="2"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" fill="none" stroke="currentColor" stroke-width="2"></path>'
    ],
    [
        'page' => 'etuNotif',
        'label' => 'Notification',
        'viewBox' => '0 0 24 24',
        'icon' => '<path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>'
    ]
];

// --- MENU ENSEIGNANT (ID = 3) ---
$menuEns = [
    [
        'page' => 'enseignantRecherche',
        'label' => 'Rechercher & Réserver',
        'viewBox' => '0 0 24 24',
        'icon' => '<circle cx="11" cy="11" r="8" fill="none" stroke="currentColor" stroke-width="2"/><line x1="21" y1="21" x2="16.65" y2="16.65" fill="none" stroke="currentColor" stroke-width="2"/>'
    ],
    [
        'page' => 'enseignantBesoins',
        'label' => 'Signaler un Besoin',
        'viewBox' => '0 0 24 24',
        'icon' => '<path d="M16 12V4H17V2H7V4H8V12L6 14V16H11V22H13V16H18V14L16 12Z" fill="currentColor"/>'
    ],
    [
        'page' => 'enseignantProposer',
        'label' => 'Proposer un objet',
        'viewBox' => '0 0 24 24',
        'icon' => '<line x1="12" y1="5" x2="12" y2="19" fill="none" stroke="currentColor" stroke-width="2"></line><line x1="5" y1="12" x2="19" y2="12" fill="none" stroke="currentColor" stroke-width="2"></line>'
    ],
    [
        'page' => 'enseignantNotif',
        'label' => 'Notifications',
        'viewBox' => '0 0 1024 1024',
        'icon' => '<path fill="currentColor" d="M880 112c-3.8 0-7.7.7-11.6 2.3L292 345.9H128c-8.8 0-16 7.4-16 16.6v299c0 9.2 7.2 16.6 16 16.6h101.7c-3.7 11.6-5.7 23.9-5.7 36.4c0 65.9 53.8 119.5 120 119.5c55.4 0 102.1-37.6 115.9-88.4l408.6 164.2c3.9 1.5 7.8 2.3 11.6 2.3c16.9 0 32-14.2 32-33.2V145.2C912 126.2 897 112 880 112M344 762.3c-26.5 0-48-21.4-48-47.8c0-11.2 3.9-21.9 11-30.4l84.9 34.1c-2 24.6-22.7 44.1-47.9 44.1m496 58.4L318.8 611.3l-12.9-5.2H184V417.9h121.9l12.9-5.2L840 203.3z"/>'
    ],
    [
        'page' => 'enseignantCollab',
        'label' => 'Collaboration',
        'viewBox' => '0 0 576 512',
        'icon' => '<path fill="currentColor" d="M268.9 53.2L152.3 182.8c-4.6 5.1-4.4 13 .5 17.9c30.5 30.5 80 30.5 110.5 0l31.8-31.8c4.2-4.2 9.5-6.5 14.9-6.9c6.8-.6 13.8 1.7 19 6.9L505.6 344l70.4-56V0L464 64l-23.8-15.9A96.2 96.2 0 0 0 386.9 32h-70.4c-1.1 0-2.3 0-3.4.1c-16.9.9-32.8 8.5-44.2 21.1m-152.3 97.5L223.4 32h-39.6c-25.5 0-49.9 10.1-67.9 28.1L0 192v352l144-136l12.4 10.3c23 19.2 52 29.7 81.9 29.7H254l-7-7c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l41 41h9c19.1 0 37.8-4.3 54.8-12.3L359 409c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l32 32l17.5-17.5c8.9-8.9 11.5-21.8 7.6-33.1L312.1 219.7l-14.9 14.9c-49.3 49.3-129.1 49.3-178.4 0c-23-23-23.9-59.9-2.2-84z"/>'
    ],
    [
        'page' => 'enseignantGuide',
        'label' => 'Guides & Bonnes pratiques',
        'viewBox' => '0 0 24 24',
        'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" fill="none" stroke="currentColor" stroke-width="2"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" fill="none" stroke="currentColor" stroke-width="2"></path>'
    ]
];

// 4. Sélection du menu actif
$currentMenu = [];
switch ($id_role) {
    case 1: $currentMenu = $menuChef; break;
    case 2: $currentMenu = $menuEtu; break;
    case 3: $currentMenu = $menuEns; break;
}
?>

<aside class="sidebar">
    <!-- HEADER -->
    <div class="sidebar-header">
        <div class="carre-rouge">&nbsp;</div>
        <div style="display:flex; flex-direction:column; justify-content:center;">
            <span class="role-title">
                <?php echo htmlspecialchars($nom_role); ?>
            </span>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="search-bar">
        <span class="search-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                <circle cx="11" cy="11" r="8" stroke="white" stroke-width="2"/>
                <line x1="17" y1="17" x2="21" y2="21" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>  
        </span>
        <input type="text" class="search-input" placeholder="Rechercher">
    </div>

    <!-- MENU DYNAMIQUE -->
    <nav class="sidebar-menu">
        <?php foreach ($currentMenu as $item): ?>
            <?php 
                $isActive = ($currentPage == $item['page']) ? 'active' : '';
                $url = "index.php?page=" . $item['page'];
                $viewBox = $item['viewBox'] ?? '0 0 24 24';
            ?>
            <a href="<?php echo $url; ?>" class="menu-item <?php echo $isActive; ?>">
                <svg class="menu-icon" width="24" height="24" viewBox="<?php echo $viewBox; ?>">
                    <?php echo $item['icon']; ?>
                </svg>
                <span><?php echo htmlspecialchars($item['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="sidebar-logo">
        <img src="images/logo_LEMANS_UNIVERSITE_Blanc-01.png" alt="Le Mans Université" />
    </div>

    <!-- FOOTER -->
    <div class="sidebar-footer">
        <div class="user"> 
            <div class="avatar" <?php if($id_role == 2) echo 'style="background-color: #D05A46;"'; ?>></div> 
            <div class="user-details"> 
                <?php
                echo "<span>" . htmlspecialchars($prenom_user . ' ' . $nom_user) . "</span>";
                echo "<span class='user-email'>" . htmlspecialchars($mail_user) . "</span>";
                ?>
            </div>
            <a href="index.php?page=login" class="logout-btn" title="Se déconnecter">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </a>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>