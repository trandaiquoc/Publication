<!-- layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>20127609_TranDaiQuoc</title>
    <link rel="stylesheet" href="public/css/layout.css">
    <script src="public/js/layout.js"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Beiruti:wght@200..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Kiểm tra session đã tồn tại và hiển thị thông báo chào
        <?php if (isset($_SESSION['user']) && !$_SESSION['welcome_shown']): ?>
            window.onload = function() {
                var username = '<?php echo $_SESSION['user']['username']; ?>';
                Swal.fire({
                    title: 'MyBookStore chào bạn, ' + username + '!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000 // Tự đóng sau 3 giây
                }).then(() => {
                    <?php $_SESSION['welcome_shown'] = true; ?>
                });
            };
        <?php endif; ?>
    </script>
</head>
<body>
    <header>
        <div class="headleft" style="display: flex;">
            <div id="logo">
                <a href="index.php?action=home">My BookStore</a>
            </div>
            <div class="features">
                <input type="submit" id="topicInput" value="Chủ Đề" onfocus="toggleTopicDropdown()">
                <div id="topicDropdown" class="topic-dropdown-content">
                    <?php
                        require_once('models/Topics.php');
                        $topics = Topics::getAllTopics();
                        foreach ($topics as $topic) {
                            echo '<a href="index.php?action=home&topic_id=' . $topic['topic_id'] . '&topic_name=' . $topic['topic_name'] . '">' . $topic['topic_name'] . '</a>';
                        }
                    ?>
                </div>
            </div>
            <div class="features">
                <a href="index.php?action=search">Tìm Kiếm</a>
            </div>
            <div class="features">
                <a href="index.php?action=addForm">Thêm Bài Báo</a>
            </div>
        </div>
        <div class="headright">
            <?php if (isset($_SESSION['user'])): ?>
                <div id="login">
                    <input type="submit" id="account" value= <?php echo $_SESSION['user']['username']; ?> onfocus="toggleAccountDropdown()">
                    <div id="accountDropdown" class="account-dropdown-content">
                        <ul>
                            <li><a href="index.php?action=logout">Đăng Xuất</a></li>
                            <li><a href="index.php?action=viewprofile">Thông Tin Cá Nhân</a></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <div id="login">
                    <a href="index.php?action=login">Đăng Nhập</a>
                </div>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <?php include($view); ?>
    </main>
    <footer>
        <p>&copy; 20127609 - Trần Đại Quốc - My BookStore</p>
    </footer>
</body>
</html>
