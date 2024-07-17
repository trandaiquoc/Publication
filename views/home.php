<?php if (!empty($papers)): ?>
    <h1><?php echo $topic_name; ?></h1>
    <br><br>
    <?php foreach ($papers as $paper): ?>
        <ul style="border-bottom: 2px solid #0e3746;">
            <li><?php echo '<h2>' . $paper['title'] . '</h2>'; ?></li>
            <li><p><b>Tác Giả: </b><i><?php echo $paper['author_string_list']; ?></i></p></li>
            <li><p><b>Tóm Tắt Nội Dung: </b><?php echo $paper['abstract']; ?><p></li>
            <li><p><b>Tên Hội Nghị: </b><?php echo $paper['name']; ?><p></li>
            <li><p><b>Tên Viêt Tắt Hội Nghị: </b><?php echo $paper['abbreviation']; ?><p></li>
            <li><p><b>Ngày Bắt Đầu: </b><?php echo $paper['start_date']; ?><p></li>
            <li><p><b>Chủ Đề: </b><?php echo $paper['topic_name']; ?><p></li>
        </ul>
        <br>
    <?php endforeach; ?>
    <style>
        ul{
            list-style-type: none;
        }
    </style>    
<?php else: ?>
    <?php include('views/error.php'); ?>
<?php endif; ?>