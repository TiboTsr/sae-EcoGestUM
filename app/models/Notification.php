<?php
require_once __DIR__ . '/../../core/Model.php';

class Notification extends Model {

    public function envoyerNotification($id_chef, $message) {
        $sql = "CALL P_EnvoyerNotificationMaterielRecycle(:id_chef, :message)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_chef', $id_chef, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getHistoriqueNotifications() {
        $sql = "SELECT DISTINCT mess_not, date_not 
                FROM NOTIFICATION 
                ORDER BY date_not DESC 
                LIMIT 5";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}