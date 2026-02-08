<?php
require_once __DIR__ . '/../../core/Model.php';

class Collab extends Model {

    // Récupérer les objets des AUTRES départements (pour la collaboration)
    public function getObjetsAutresDepartements($id_mon_dep) {
        $sql = "SELECT 
                    o.nom_obj, 
                    c.nom_cat, 
                    o.quantite_obj, 
                    o.etat_obj_, 
                    d.nom_dep
                FROM OBJET o
                JOIN CATEGORIE c ON o.id_cat = c.id_cat
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                JOIN DEPARTEMENT d ON i.id_dep = d.id_dep
                WHERE i.id_dep != :id_mon_dep 
                AND o.statut_obj = 'disponible'
                ORDER BY d.nom_dep, o.nom_obj";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_mon_dep', $id_mon_dep, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer l'ID inventaire de mon département (pour l'ajout)
    public function getIdInventaireByDep($id_dep) {
        $sql = "SELECT id_invent FROM INVENTAIRE WHERE id_dep = :id_dep LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_dep' => $id_dep]);
        return $stmt->fetchColumn();
    }

    public function getIdCategorieByNom($nom_cat) {
        $sql = "SELECT id_cat FROM CATEGORIE WHERE nom_cat = :nom_cat LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nom_cat' => $nom_cat]);
        return $stmt->fetchColumn();
    }

    public function ajouterObjet($nom, $description, $etat, $quantite, $id_cat, $id_invent) {
        $sql = "INSERT INTO OBJET (nom_obj, description_obj, etat_obj_, quantite_obj, date_ajout_obj, statut_obj, id_cat, id_invent) 
                VALUES (:nom, :desc, :etat, :qte, NOW(), 'Disponible', :id_cat, :id_invent)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom, ':desc' => $description, ':etat' => $etat, ':qte' => $quantite, ':id_cat' => $id_cat, ':id_invent' => $id_invent
        ]);
    }
}