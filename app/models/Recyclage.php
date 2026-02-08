<?php
require_once __DIR__ . '/../../core/Model.php';

class Recyclage extends Model {

    // Récupère l'historique des recyclages liés au département
    public function getHistoriqueByDepartement($id_dep) {
        $sql = "SELECT 
                    r.date_recycl,
                    r.qte_recycl,
                    r.statut_recycl,
                    o.nom_obj,
                    c.nom_cat
                FROM RECYCLAGE r
                JOIN OBJET o ON r.id_obj = o.id_obj
                JOIN CATEGORIE c ON o.id_cat = c.id_cat
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                WHERE i.id_dep = :id_dep
                ORDER BY r.date_recycl DESC"; // Du plus récent au plus vieux

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}