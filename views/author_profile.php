<link rel="stylesheet" href="public/css/author_profile.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // Kiểm tra session đã tồn tại và hiển thị thông báo chào
        <?php if (isset($_SESSION['success_message']) && $_SESSION['success_message']): ?>
            window.onload = function() {
                Swal.fire({
                    title: 'Cập nhật thành công!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 3000 // Tự đóng sau 3 giây
                }).then(() => {
                    <?php $_SESSION['success_message'] = false; ?>
                });
            };
        <?php endif; ?>
    </script>
<?php if (isset($author) && isset($profile)): ?>
    <div class="author-profile">
        <div class="leftpanel">
            <?php if($author['image_path'] != ""): ?>
                <img class= "profilepic" src="<?php echo "./public" . htmlspecialchars($author['image_path']); ?>" alt="Author Image" />
            <?php else:?>
                <img class= "profilepic" src="./public/images/profile-icon-empty.png" alt="Author Image" />
            <?php endif; ?>
            <h2><?php echo htmlspecialchars($author['full_name']); ?></h2>
            <?php if (!empty($profile['bio'])): 
                $bio = htmlspecialchars($profile['bio']);?>
            <?php else: 
                $bio = "Đây là người dùng mới!"?>
            <?php endif; ?>
            <p style="margin-bottom: 10vh;"><?php echo $bio; ?></p>
        </div>
        <div class="rightpanel">
            <p><b>Website: </b><a href="<?php echo htmlspecialchars($author['website']); ?>"><?php echo htmlspecialchars($author['website']); ?></a></p>
            
            <div class="profile-section">
                <ul>
                    <p><b>Hướng nghiên cứu quan tâm</b></p>
                    <?php if (!empty($profile['interests'])): ?>
                        <?php foreach ($profile['interests'] as $interest): ?>
                            <li><?php echo htmlspecialchars($interest); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <br>
                    <p><b>Đào tạo</b></p>
                    <?php if (!empty($profile['education'])): ?>
                        <?php foreach ($profile['education'] as $education): ?>
                            <li><?php echo htmlspecialchars($education); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <br>
                    <p><b>Quá trình làm việc/Công tác</b></p>
                    <?php if (!empty($profile['work_experiences'])): ?>
                        <?php foreach ($profile['work_experiences'] as $work_experience): ?>
                            <li><?php echo htmlspecialchars($work_experience); ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <br>
                </ul>
                <p><b>Bài Viết Tham Gia</b></p>
                <br>
                <table>
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Tác giả</th>
                            <th>Tóm tắt</th>
                            <th>Chức Vụ</th>
                            <th>Ngày Tham Gia</th>
                            <th>Show/Hide</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($papers as $paper): ?>
                            <tr>
                                
                                <td onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper['paper_id']; ?>'"><?php echo htmlspecialchars($paper['title']); ?></td>
                                <td onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper['paper_id']; ?>'"><?php echo htmlspecialchars($paper['author_string_list']); ?></td>
                                <td onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper['paper_id']; ?>'"><?php echo htmlspecialchars($paper['abstract']); ?></td>
                                <td onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper['paper_id']; ?>'"><?php echo htmlspecialchars($paper['role']); ?></td>
                                <td onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper['paper_id']; ?>'"><?php echo htmlspecialchars($paper['date_added']); ?></td>
                                <td onclick="window.location.href='index.php?action=changeStatus&author_id=<?php echo $author['user_id']; ?>&paper_id=<?php echo $paper['paper_id']; ?>&status=<?php echo $paper['status']; ?>'"><?php echo htmlspecialchars($paper['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="index.php?action=editprofile" class="update-profile-button">Cập nhật profile</a>
        </div>
    </div>
<?php else: ?>
    <p>Không tìm thấy thông tin tác giả.</p>
<?php endif; ?>
