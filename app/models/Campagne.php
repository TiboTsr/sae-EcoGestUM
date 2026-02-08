<?php
require_once __DIR__ . '/../../core/Model.php';

class Campagne extends Model
{

    public function getAllCampagnes()
    {
        $sql = "SELECT * FROM CAMPAGNE ORDER BY date_pub_camp ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inscrire($id_user, $id_camp)
    {
        $check = "SELECT COUNT(*) FROM PARTICIPATION_CAMPAGNE WHERE id_user = ? AND id_camp = ?";
        $stmt = $this->db->prepare($check);
        $stmt->execute([$id_user, $id_camp]);

        if ($stmt->fetchColumn() == 0) {
            $sql = "INSERT INTO PARTICIPATION_CAMPAGNE (id_user, id_camp) VALUES (?, ?)";
            $stmtInsert = $this->db->prepare($sql);
            return $stmtInsert->execute([$id_user, $id_camp]);
        }
        return false;
    }

    public function getInscriptionsUser($id_user)
    {
        $sql = "SELECT id_camp FROM PARTICIPATION_CAMPAGNE WHERE id_user = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user]);

        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return array_map('intval', $results);
    }

    public function desinscrire($id_user, $id_camp)
    {
        $sql = "DELETE FROM PARTICIPATION_CAMPAGNE WHERE id_user = ? AND id_camp = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_user, $id_camp]);
    }
}
