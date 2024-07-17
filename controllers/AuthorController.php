<?php
require_once('models/Authors.php');
require_once('models/Papers.php');
require_once('Controller.php');

class AuthorController extends Controller {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user_id = $_SESSION['user']['user_id'];
        $author = Authors::getAuthorByUserId($user_id);

        if ($author) {
            $profile = json_decode($author['profile_json_text'], true);
            $papers = Papers::find($author['user_id']);
            $this->loadView('author_profile.php',  ['author' => $author, 'profile' => $profile, 'papers' => $papers]);
        } else {
            $error = "Không tìm thấy thông tin tác giả.";
            $this->loadView('author_profile.php',  ['error' => $error]);
        }
    }

    public function edit() {
        $error = '';
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $user_id = $_SESSION['user']['user_id'];
        $author = Authors::getAuthorByUserId($user_id);
        if ($author) {
            $profile = json_decode($author['profile_json_text'], true);
        } else {
            $error = "Không load được dữ liệu";
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $author_id = $author['user_id'];
            if (!$author_id) {
                $error = "Không tìm thấy tác giả để cập nhật.";
            } else {
                $uploadDir = './public/images/';  // Thư mục lưu ảnh trong public
                $uploadFile = $uploadDir . basename($_FILES['image_path']['name']);

                if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadFile)) {
                    $image_path = '/images/' . basename($_FILES['image_path']['name']);  // Đường dẫn lưu trong cơ sở dữ liệu
                }
                // Lấy các dữ liệu từ form
                $full_name = $_POST['name'];
                $website = $_POST['website'];
                $bio = $_POST['bio'];
                $interests = explode("\n", $_POST['interests']);
                $education = explode("\n", $_POST['education']);
                $work_experiences = explode("\n", $_POST['work_experiences']);
    
                // Chuẩn bị dữ liệu cho profile_json_text
                $profile_data = array(
                    'bio' => $bio,
                    'interests' => $interests,
                    'education' => $education,
                    'work_experiences' => $work_experiences
                );
                $profile_json_text = json_encode($profile_data);
    
                // Cập nhật thông tin vào database
                $result = Authors::update($author_id, $full_name, $website, $profile_json_text, $image_path);
    
                if ($result) {
                    // Đặt thông báo thành công vào session
                    $_SESSION['success_message'] = true;
                    // Điều hướng về trang xem profile
                    header('Location: index.php?action=viewprofile');
                    exit;
                } else {
                    $error = "Không thể cập nhật profile.";
                }
            }
        }
    
        // Load view để hiển thị form chỉnh sửa profile
        $this->loadView('edit_profile.php', ['error' => $error, 'author' => $author, 'profile' => $profile]);
    }

    public function changeStatus() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if (isset($_GET['paper_id']) && isset($_GET['author_id']) && isset($_GET['status']))
        {
            if($_GET['status'] == 'show')
            {
                $status = 'hide';
            }
            else{
                $status = 'show';
            }
            $paper_id = $_GET['paper_id'];
            $author_id = $_GET['author_id'];
            $result = Authors::changeStatus($author_id, $paper_id, $status);
    
            if ($result) {
                header('Location: index.php?action=viewprofile');
                exit;
            } else {
                $error = "Không thể cập nhật status.";
            }
        }
    }

    public function checkOthers() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if (isset($_GET['author_id']))
        {
            $author_id = $_GET['author_id'];
            $author = Authors::getAuthorByUserId($author_id);
            if ($author) {
                $profile = json_decode($author['profile_json_text'], true);
                $papers = Papers::find($author['user_id']);
                $this->loadView('check_profile_others.php',  ['author' => $author, 'profile' => $profile, 'papers' => $papers]);
            } else {
                $error = "Không tìm thấy thông tin tác giả.";
                $this->loadView('check_profile_others.php',  ['error' => $error]);
            }
        }
    }
}
?>
