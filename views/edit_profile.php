<link rel="stylesheet" href="public/css/edit_profile.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container">
    <?php if (!empty($error)): ?>
        <script>
            window.onload = function() {
                Swal.fire({
                    title: 'Lỗi: ' + $error,
                    icon: 'error',
                    showConfirmButton: true,
                })
            };
        </script>
            <?php
                header('Location: index.php?action=viewProfile');
                exit;
            ?>
    <?php endif; ?>
    <form method="POST" action="index.php?action=editprofile" enctype="multipart/form-data">
        <input type="hidden" name="author_id" value="<?php echo htmlspecialchars($author['user_id']); ?>">
        <div class="author-profile">
            <div class="leftpanel">
                <?php if($author['image_path'] != ""): ?>
                    <img class= "profilepic" src="<?php echo "./public" . htmlspecialchars($author['image_path']); ?>" alt="Author Image" />
                <?php else:?>
                    <img class= "profilepic" src="./public/images/profile-icon-empty.png" alt="Author Image" />
                <?php endif; ?>
                <div class="form-group">
                    <label for="image">Chọn ảnh đại diện:</label>
                    <input type="file" id="image" name="image_path">
                </div>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($author['full_name']);?>"/>
                <?php if (!empty($profile['bio'])): 
                    $bio = htmlspecialchars($profile['bio']);?>
                <?php else: 
                    $bio = ""?>
                <?php endif; ?>
                <textarea id="bio" name="bio"><?php echo $bio; ?></textarea>
            </div>
            <div class="rightpanel">
                <div class="form-group">
                    <label for="website">Trang web cá nhân:</label>
                    <input type="text" id="website" name="website" value="<?php echo htmlspecialchars($author['website']); ?>"/>
            </div>      
                <div class="profile-section">
                    <ul>
                        <div class="form-group">
                            <label for="interests">Hướng nghiên cứu quan tâm:</label>
                            <?php if (!empty($profile['interests'])): 
                                $insterests = htmlspecialchars(implode("\n", $profile['interests']));?>
                            <?php else: 
                                $insterests = ""?>
                            <?php endif; ?>
                            <textarea id="interests" name="interests"><?php echo $insterests; ?></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="education">Đào tạo:</label>
                            <?php if (!empty($profile['education'])): 
                                $education = htmlspecialchars(implode("\n", $profile['education']));?>
                            <?php else: 
                                $education = ""?>
                            <?php endif; ?>
                            <textarea id="education" name="education"><?php echo $education; ?></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="work_experiences">Quá trình làm việc/Công tác:</label>
                            <?php if (!empty($profile['work_experiences'])): 
                                $work_experiences = htmlspecialchars(implode("\n", $profile['work_experiences']));?>
                            <?php else: 
                                $work_experiences = ""?>
                            <?php endif; ?>
                            <textarea id="work_experiences" name="work_experiences"><?php echo $work_experiences; ?></textarea>
                        </div>
                        <br>
                    </ul>
                </div>
                <div class="buttonsection">
                    <button class="buttonsubmit" type="submit">Cập Nhật</button>
                    <a href="index.php?action=viewprofile" class="buttoncancel">Hủy</a>
                </div>
                <p id="note"><i>*LƯU Ý: các phần Hướng nghiên cứu quan tâm, Đào tạo, Quá trình làm việc/Công tác được phân biệt nhau bởi dấu enter</i></p>
            </div>
        </div>
    </form>
</div>