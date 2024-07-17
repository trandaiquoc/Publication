<?php
require_once('models/Users.php');

class UserController extends Controller {
    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (!empty($username) && !empty($password)) {
                // Attempt authentication
                $user = Users::authenticate($username, $password);
                
                if ($user) {
                    // Authentication successful
                    session_start();
                    $_SESSION['user'] = $user; // Store user data in session
                    $_SESSION['welcome_shown'] = false;
                    
                    // Redirect to another page or perform other actions
                    header('Location: index.php'); // Redirect to main page
                    exit;
                } else {
                    // Authentication failed
                    $error_message = "Invalid username or password.";
                    $this->loadView('login.php', ['error' => $error_message]);
                }
            } else {
                // Handle empty username or password
                $error_message = "Username and password are required.";
                $this->loadView('login.php', ['error' => $error_message]);
            }
        } else {
            $this->loadView('login.php');
        }
    }

    public function logout() {
        session_start();
        unset($_SESSION['user']);
        session_destroy();
        header('Location: index.php'); // Redirect to main page after logout
        exit;
    }
}
?>
