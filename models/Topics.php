<?php
class Topics {
    private $db;

    public static function getAllTopics() {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM topics");
        $stmt->execute();
        $result = $stmt->get_result();
        $topics = array();
        while ($row = $result->fetch_assoc()) {
            $topics[] = $row;
        }
        $stmt->close();
        $db->close();
        return $topics;
    }
}
?>
