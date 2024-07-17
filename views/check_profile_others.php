<link rel="stylesheet" href="public/css/author_profile.css">
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($papers as $paper): ?>
                            <tr>
                                
                                <td><?php echo htmlspecialchars($paper['title']); ?></td>
                                <td><?php echo htmlspecialchars($paper['author_string_list']); ?></td>
                                <td><?php echo htmlspecialchars($paper['abstract']); ?></td>
                                <td><?php echo htmlspecialchars($paper['role']); ?></td>
                                <td><?php echo htmlspecialchars($paper['date_added']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <p>Không tìm thấy thông tin tác giả.</p>
<?php endif; ?>
