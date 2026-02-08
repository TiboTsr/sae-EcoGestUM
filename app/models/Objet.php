<?php
require_once __DIR__ . '/../../core/Model.php';
class Objet extends Model {


    public function getObjetsByDepartement($id_dep) {
       
        $sql = "SELECT 
                    o.nom_obj, 
                    c.nom_cat, 
                    o.quantite_obj, 
                    o.etat_obj_, 
                    o.date_ajout_obj
                FROM OBJET o
                JOIN CATEGORIE c ON o.id_cat = c.id_cat
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                WHERE i.id_dep = :id_dep";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_dep', $id_dep, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
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
            ':nom' => $nom,
            ':desc' => $description,
            ':etat' => $etat,
            ':qte' => $quantite,
            ':id_cat' => $id_cat,
            ':id_invent' => $id_invent
        ]);
    }


public function rechercherAvecFiltres($categories = [], $etats = [], $recherche = '') {
        
        $sql = "SELECT 
                    o.id_obj, 
                    o.nom_obj, 
                    o.description_obj, 
                    o.etat_obj_, 
                    o.quantite_obj, 
                    c.nom_cat, 
                    pc.nom_pc 
                FROM OBJET o
                JOIN CATEGORIE c ON o.id_cat = c.id_cat
                JOIN INVENTAIRE i ON o.id_invent = i.id_invent
                JOIN POINT_DE_COLLECTE pc ON i.id_pc = pc.id_pc
                WHERE o.statut_obj = 'Disponible'"; 

        $params = [];

        
        if (!empty($categories)) {
            $placeholders = str_repeat('?,', count($categories) - 1) . '?';
            $sql .= " AND c.nom_cat IN ($placeholders)";
            
            $params = array_merge($params, $categories);
        }

        if (!empty($etats)) {
            $placeholders = str_repeat('?,', count($etats) - 1) . '?';
            $sql .= " AND o.etat_obj_ IN ($placeholders)"; 
            $params = array_merge($params, $etats);
        }

        if (!empty($recherche)) {
            $sql .= " AND (o.nom_obj LIKE ? OR o.description_obj LIKE ?)";
            $searchTerm = "%" . $recherche . "%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function reserverObjet($id_obj, $id_user, $usage, $quantite_demandee) {
        try {
            $this->db->beginTransaction();

            $sqlCheck = "SELECT quantite_obj FROM OBJET WHERE id_obj = :id";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute([':id' => $id_obj]);
            $stock_actuel = $stmtCheck->fetchColumn();

            if ($stock_actuel < $quantite_demandee) {
                $this->db->rollBack();
                return false; 
            }

            $sqlRes = "INSERT INTO RESERVATION (usage_res, qte_res, date_res, statut_res, id_obj, id_user) 
                       VALUES (:usage, :qte, NOW(), 'En attente', :id_obj, :id_user)";
            $stmtRes = $this->db->prepare($sqlRes);
            $stmtRes->execute([
                ':usage'   => $usage,
                ':qte'     => $quantite_demandee,
                ':id_obj'  => $id_obj,
                ':id_user' => $id_user
            ]);

            $lastInsertId = $this->db->lastInsertId();

            $nouveau_stock = $stock_actuel - $quantite_demandee;
            

            $nouveau_statut = ($nouveau_stock == 0) ? 'Indisponible' : 'Disponible';

            $sqlUpdate = "UPDATE OBJET SET quantite_obj = :nv_stock, statut_obj = :nv_statut WHERE id_obj = :id";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':nv_stock'  => $nouveau_stock,
                ':nv_statut' => $nouveau_statut,
                ':id'        => $id_obj
            ]);

            $this->db->commit();
            return $lastInsertId ? $lastInsertId : true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getMesReservations($id_user) {
        $sql = "SELECT 
                    r.id_res,
                    r.date_res,
                    r.qte_res,
                    r.statut_res,
                    r.usage_res,
                    o.nom_obj,
                    o.description_obj
                FROM RESERVATION r
                JOIN OBJET o ON r.id_obj = o.id_obj
                WHERE r.id_user = :id_user
                ORDER BY r.date_res DESC"; 

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_user' => $id_user]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function annulerReservation($id_res) {
        try {
            $this->db->beginTransaction();

            $sqlInfo = "SELECT id_obj, qte_res, statut_res FROM RESERVATION WHERE id_res = :id_res";
            $stmtInfo = $this->db->prepare($sqlInfo);
            $stmtInfo->execute([':id_res' => $id_res]);
            $res = $stmtInfo->fetch(PDO::FETCH_ASSOC);

            if (!$res || $res['statut_res'] === 'Annulée') {
                $this->db->rollBack();
                return false;
            }

            $sqlUpdateRes = "UPDATE RESERVATION SET statut_res = 'Annulée' WHERE id_res = :id_res";
            $stmtUpdateRes = $this->db->prepare($sqlUpdateRes);
            $stmtUpdateRes->execute([':id_res' => $id_res]);

        
            $sqlUpdateObj = "UPDATE OBJET 
                             SET quantite_obj = quantite_obj + :qte, 
                                 statut_obj = 'Disponible' 
                             WHERE id_obj = :id_obj";
                             
            $stmtUpdateObj = $this->db->prepare($sqlUpdateObj);
            $stmtUpdateObj->execute([
                ':qte' => $res['qte_res'], 
                ':id_obj' => $res['id_obj']
            ]);

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Mettre à jour une réservation (quantité et motif) si elle est encore modifiable
    public function updateReservation($id_res, $qte, $usage) {
        try {
            $sql = "UPDATE RESERVATION SET qte_res = :qte, usage_res = :usage WHERE id_res = :id_res AND statut_res = 'En attente'";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':qte' => $qte,
                ':usage' => $usage,
                ':id_res' => $id_res
            ]);
        } catch (Exception $e) {
            return false;
        }
    }

    // Modifier la quantité d'une réservation (ajuste le stock en conséquence)
    public function modifierReservation($id_res, $nouvelle_qte) {
        try {
            $this->db->beginTransaction();

            // Récupérer info réservation
            $sqlInfo = "SELECT id_obj, qte_res, statut_res FROM RESERVATION WHERE id_res = :id_res FOR UPDATE";
            $stmtInfo = $this->db->prepare($sqlInfo);
            $stmtInfo->execute([':id_res' => $id_res]);
            $res = $stmtInfo->fetch(PDO::FETCH_ASSOC);

            if (!$res) {
                $this->db->rollBack();
                return false;
            }

            $id_obj = $res['id_obj'];
            $ancienne_qte = (int)$res['qte_res'];

            if ($res['statut_res'] === 'Annulée') {
                $this->db->rollBack();
                return false;
            }

            $diff = $nouvelle_qte - $ancienne_qte;

            if ($diff > 0) {
                // On augmente la demande: vérifier le stock
                $sqlCheck = "SELECT quantite_obj FROM OBJET WHERE id_obj = :id";
                $stmtCheck = $this->db->prepare($sqlCheck);
                $stmtCheck->execute([':id' => $id_obj]);
                $stock_actuel = (int)$stmtCheck->fetchColumn();

                if ($stock_actuel < $diff) {
                    $this->db->rollBack();
                    return false; // pas assez de stock
                }

                // Déduire du stock
                $sqlUpObj = "UPDATE OBJET SET quantite_obj = quantite_obj - :diff WHERE id_obj = :id_obj";
                $stmtUpObj = $this->db->prepare($sqlUpObj);
                $stmtUpObj->execute([':diff' => $diff, ':id_obj' => $id_obj]);
            } elseif ($diff < 0) {
                // On réduit la demande: restituer au stock
                $restaurer = -$diff;
                $sqlUpObj = "UPDATE OBJET SET quantite_obj = quantite_obj + :qte WHERE id_obj = :id_obj";
                $stmtUpObj = $this->db->prepare($sqlUpObj);
                $stmtUpObj->execute([':qte' => $restaurer, ':id_obj' => $id_obj]);
            }

            // Mettre à jour la réservation
            $sqlUpd = "UPDATE RESERVATION SET qte_res = :qte WHERE id_res = :id_res";
            $stmtUpd = $this->db->prepare($sqlUpd);
            $stmtUpd->execute([':qte' => $nouvelle_qte, ':id_res' => $id_res]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
