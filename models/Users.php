<?php
class Users {
    private $db;

    public static function authenticate($username, $password) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM USERS WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // Lấy mật khẩu từ CSDL
            $stored_password = $row['password'];
            // Kiểm tra mật khẩu
            if ($password === $stored_password) {
                // Mật khẩu hợp lệ, trả về thông tin người dùng
                return $row;
            } else {
                // Mật khẩu không hợp lệ
                return null;
            }
        } else {
            // Không tìm thấy người dùng với username này
            return null;
        }
    }
}
?>