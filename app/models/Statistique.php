<?php
require_once __DIR__ . '/../../core/Model.php';

class Statistique extends Model {

    // KPI 1 : Estimation économie (Nb objets * valeur arbitraire, ex: 50€)
    public function getEconomieRealisee($id_dep) {
        $sql = "SELECT (COUNT(*) * 50) as total 
                FROM OBJET o
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                WHERE i.id_dep = :id_dep AND o.statut_obj = 'disponible'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchColumn() ?: 0;
    }

    // KPI 2 : Total Matériaux Recyclés (Somme qte_recycl dans la table RECYCLAGE)
    public function getPoidsRecycle($id_dep) {
        // On joint Recyclage -> Objet -> Inventaire -> Département
        $sql = "SELECT SUM(r.qte_recycl) 
                FROM RECYCLAGE r
                JOIN OBJET o ON r.id_obj = o.id_obj
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                WHERE i.id_dep = :id_dep";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchColumn() ?: 0;
    }

    // KPI 3 : Taux de réutilisation (Depuis la table STATISTIQUE si dispo, sinon calcul)
    public function getTauxReutilisation($id_dep) {
        $sql = "SELECT donnee_stat FROM STATISTIQUE 
                WHERE type_stat = 'TauxRecyclage' AND id_dep = :id_dep 
                ORDER BY periode_stat DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchColumn() ?: 0;
    }

    // Graphique : Bilan Carbone (Volume Composté ou Collecté par année/mois)
    public function getEvolutionCarbone($id_dep) {
        $sql = "SELECT DATE_FORMAT(periode_stat, '%Y') as annee, SUM(donnee_stat) as total
                FROM STATISTIQUE
                WHERE (type_stat = 'VolumeCollecté' OR type_stat = 'VolumeComposté')
                AND id_dep = :id_dep
                GROUP BY annee
                ORDER BY annee ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Meilleur Recycleur (Celui qui a fait le plus de demandes de recyclage validées)
    public function getMeilleurRecycleur($id_dep) {
        $sql = "SELECT u.nom_user, u.prenom_user, u.mail_user, SUM(r.qte_recycl) as total
                FROM RECYCLAGE r
                JOIN UTILISATEUR u ON r.id_user = u.id_user
                JOIN OBJET o ON r.id_obj = o.id_obj
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                WHERE i.id_dep = :id_dep AND r.statut_recycl = 'validé'
                GROUP BY u.id_user
                ORDER BY total DESC
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getRepartitionMateriaux($id_dep) {
        $sql = "SELECT c.nom_cat, COUNT(o.id_obj) as total
                FROM OBJET o
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                JOIN CATEGORIE c ON o.id_cat = c.id_cat
                WHERE i.id_dep = :id_dep
                GROUP BY c.id_cat";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}