<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/search.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
<h1>Tìm Kiếm Bài Viết</h1>
<div id="searchdiv">
    <input class="searchtext" type="text" name="input" autocomplete="off" placeholder="Nhập từ khóa...">
</div>
<div id="searchresult">
    <table>
        <thead>
            <tr>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Tóm tắt</th>
                <th>Tên Hội Nghị</th>
                <th>Tên Viêt Tắt Hội Nghị</th>
                <th>Ngày Bắt Đầu</th>
                <th>Chủ Đề</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($papers as $paper): ?>
            <tr onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo htmlspecialchars($paper['paper_id']); ?>'">
                <td><?php echo htmlspecialchars($paper['title']); ?></td>
                <td><?php echo htmlspecialchars($paper['author_string_list']); ?></td>
                <td><?php echo htmlspecialchars($paper['abstract']); ?></td>
                <td><?php echo htmlspecialchars($paper['name']); ?></td>
                <td><?php echo htmlspecialchars($paper['abbreviation']); ?></td>
                <td><?php echo htmlspecialchars($paper['start_date']); ?></td>
                <td><?php echo htmlspecialchars($paper['topic_name']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Phân trang -->
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a style="margin-right: 2rem;" href="index.php?action=search&page=<?php echo $current_page - 1; ?>">Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a class="nmb" href="index.php?action=search&page=<?php echo $i; ?>" <?php if ($i == $current_page) echo 'class="active"'; ?>><?php echo $i; ?></a>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
            <a style="margin-left: 2rem;" href="index.php?action=search&page=<?php echo $current_page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</div>
<script>
        $(document).ready(function() {
            $(".searchtext").keyup(function() {
                var input = $(this).val();
                if(input != "") {
                    $.ajax({
                        url: "index.php?action=searchAjax",
                        method: "POST",
                        data: {input: input},
                        success: function(data) {
                            $("#searchresult").html(data);
                        },
                    });
                }
            });
        });
    </script>
</body>
</html>
