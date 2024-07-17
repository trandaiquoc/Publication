<link rel="stylesheet" href="public/css/view_paper.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    // Kiểm tra session đã tồn tại và hiển thị thông báo chào
    <?php if (isset($_SESSION['deletestatus']) && !$_SESSION['deletestatus']): ?>
        window.onload = function() {
            Swal.fire({
                title: 'Xóa thất bại!',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Tự đóng sau 3 giây
            }).then(() => {
                <?php unset($_SESSION['deletestatus']); ?>
            });
        };
    <?php elseif (isset($_SESSION['deletestatus']) && $_SESSION['deletestatus']): ?>
        window.onload = function() {
            Swal.fire({
                title: 'Xóa thành công!',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000 // Tự đóng sau 3 giây
            }).then(() => {
                <?php unset($_SESSION['deletestatus']); ?>
            });
        };
    <?php elseif (isset($_SESSION['addmemberstatus']) && $_SESSION['addmemberstatus']): ?>
        window.onload = function() {
            Swal.fire({
                title: 'Thêm thành công!',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000 // Tự đóng sau 3 giây
            }).then(() => {
                <?php unset($_SESSION['addmemberstatus']); ?>
            });
        };
    <?php elseif (isset($_SESSION['addmemberstatus']) && !$_SESSION['addmemberstatus']): ?>
        window.onload = function() {
            Swal.fire({
                title: 'Thêm thất bại!',
                icon: 'error',
                showConfirmButton: false,
                timer: 3000 // Tự đóng sau 3 giây
            }).then(() => {
                <?php unset($_SESSION['addmemberstatus']); ?>
            });
        };
    <?php endif; ?>
</script>
<h1><?php echo htmlspecialchars($paper['title']); ?></h1>
<p><b>Nội dung: </b><?php echo htmlspecialchars($paper['abstract']); ?></p>
<p><b>Chủ đề: </b><?php echo htmlspecialchars($paper['topic_name']); ?></p>
<p><b>Hội nghị khoa học: </b><?php echo htmlspecialchars($paper['name']) . " (" . htmlspecialchars($paper['abbreviation']) . ")"; ?></p>
<p><b>Thời gian: </b><?php echo "<i>". htmlspecialchars($paper['start_date']) . "</i>  ~  <i>" . htmlspecialchars($paper['end_date']) . "</i>"; ?></p>
<p><b>Xếp Hạng: </b><?php echo htmlspecialchars($paper['rank']); ?></p>
<h2>Thành viên tham gia</h2>
<ul>
    <?php foreach ($participants as $participant): ?>
        <li>
            <a style="color: #0e3746; font-size: 1.5rem;" href="index.php?action=checkOthers&author_id=<?php echo $participant['author_id']; ?>" class="author-link"><?php echo htmlspecialchars($participant['full_name']); ?></a>
            <?php $par = htmlspecialchars($participant['role']);
            if ($par == 'first_author'): 
            {
                $par = 'Tác Giả';
            }else:
            {
                $par = 'Thành Viên';
            }endif;?>
            <p><b>Chức vụ: </b><?php echo $par; ?></p>
            <?php if ($_SESSION['user']['user_type'] == 'admin'): ?>
                <form method="post" action="index.php?action=deleteParticipant">
                    <input type="hidden" name="paper_id" value="<?php echo $paper_id; ?>">
                    <input type="hidden" name="author_id" value="<?php echo $participant['author_id']; ?>">
                    <button type="submit">Xóa</button>
                </form>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
<?php if (isset($_SESSION['user']) && !$author): ?>
    <form method="post" action="index.php?action=addParticipant">
        <input type="hidden" name="paper_id" value="<?php echo $paper_id; ?>">
        <button id="add" type="submit">Thêm vào thành viên</button>
    </form>
<?php endif; ?>
