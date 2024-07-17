<?php
class Authors {
    private $db;

    public static function getAuthorByUserId($user_id) {
        $user_id = (int)$user_id;
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM AUTHORS WHERE user_id = ?");
        $stmt->bind_param('i',$user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public static function getAuthorByAuthorId($user_id) {
        $user_id = (int)$user_id;
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM AUTHORS WHERE user_id = ?");
        $stmt->bind_param('i',$user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function update($user_id, $name, $website, $profile_json_text, $image) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE AUTHORS SET full_name = ?, website = ?, profile_json_text = ?, image_path = ? WHERE user_id = ?");
        $stmt->bind_param('ssssi', $name, $website, $profile_json_text, $image, $user_id);
        return $stmt->execute();
    }
    public static function changeStatus($author_id, $paper_id, $status) {
        $db = getDB();
        $stmt = $db->prepare("UPDATE PARTICIPATION SET status = ? WHERE author_id = ? AND paper_id = ?");
        $stmt->bind_param('sii', $status, $author_id, $paper_id);
        return $stmt->execute();
    }
    public static function getAllAuthors($user_id) {
        $db = getDB(); // Assuming getDB() returns a mysqli connection
        $sql = "SELECT user_id, full_name FROM authors WHERE user_id <> ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
