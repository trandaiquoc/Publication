<?php
class Conferences {
    private $db;

    public static function getAllConferences() {
        $db = getDB();
        $sql = "SELECT conference_id, name FROM conferences";
        $result = $db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
