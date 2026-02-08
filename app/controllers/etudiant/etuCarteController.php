<?php

require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../../core/View.php';

class EtuCarteController extends Controller
{

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $points = [
            [
                'id_pc' => 1,
                'nom_pc' => 'Collecte Hall A (Le Mans)',
                'adresse_pc' => '12 rue Pasteur, Le Mans',
                'latitude' => 48.0165,
                'longitude' => 0.1690
            ],
            [
                'id_pc' => 2,
                'nom_pc' => 'Collecte Amphi (Le Mans)',
                'adresse_pc' => '14 rue Voltaire, Le Mans',
                'latitude' => 48.0160,
                'longitude' => 0.1700
            ],
            [
                'id_pc' => 3,
                'nom_pc' => 'Collecte Bât. Sciences (Le Mans)',
                'adresse_pc' => '22 avenue Université, Le Mans',
                'latitude' => 48.0155,
                'longitude' => 0.1685
            ],
            [
                'id_pc' => 7,
                'nom_pc' => 'Collecte BU (Le Mans)',
                'adresse_pc' => '19 avenue Savoirs, Le Mans',
                'latitude' => 48.0158,
                'longitude' => 0.1675
            ],
            [
                'id_pc' => 9,
                'nom_pc' => 'Collecte Gymnase (Le Mans)',
                'adresse_pc' => 'Rue Sport, Le Mans',
                'latitude' => 48.0175,
                'longitude' => 0.1650
            ],

            [
                'id_pc' => 4,
                'nom_pc' => 'Collecte Cantine (Laval)',
                'adresse_pc' => '52 Rue des Docteurs Calmette, Laval',
                'latitude' => 48.0865117851926,
                'longitude' => -0.7571393251419067
            ],
            [
                'id_pc' => 5,
                'nom_pc' => 'Collecte Rez-de-chaussée (Laval)',
                'adresse_pc' => 'Bâtiment info, IUT Laval',
                'latitude' => 48.08601009654516,
                'longitude' => -0.7595854997634889
            ],
            [
                'id_pc' => 6,
                'nom_pc' => 'Collecte Parvis (Laval)',
                'adresse_pc' => 'Entrée Principale, Laval',
                'latitude' => 48.0858452549215,
                'longitude' => -0.7577186822891236
            ],
            [
                'id_pc' => 8,
                'nom_pc' => 'Collecte Fablab (Laval)',
                'adresse_pc' => 'Rue de la Maillarderie, Laval',
                'latitude' => 48.08583450436247,
                'longitude' => -0.7587164640426637
            ],
            [
                'id_pc' => 10,
                'nom_pc' => 'Collecte Atelier (Laval)',
                'adresse_pc' => 'Zone Technique, Laval',
                'latitude' => 48.08583784903939,
                'longitude' => -0.7579976320266724
            ]
        ];

        $data = [
            'title' => 'Carte des points de collecte',
            'points' => $points
        ];

        $this->loadView('/etudiant/etuCarte', $data);
    }
}
