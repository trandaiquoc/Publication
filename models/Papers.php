<?php
class Papers {
    private $db;

    public static function getTop5PapersByTopic($topic) {
        $topic = (int)$topic;
        $db = getDB();
        $query = "SELECT p.*, c.name, c.abbreviation, c.start_date, t.topic_name FROM papers p " .
        "INNER JOIN conferences c ON p.conference_id = c.conference_id " . 
        "INNER JOIN topics t ON p.topic_id = t.topic_id " . 
        "WHERE t.topic_id = ? LIMIT 5";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $topic);
        $stmt->execute();
        $result = $stmt->get_result();
        $papers = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $db->close();
        return $papers;
    }

    public static function getAll($current_page, $per_page) {
        $db = getDB();
        
        // Tính toán offset
        $offset = ($current_page - 1) * $per_page;
        
        // Truy vấn dữ liệu sử dụng prepared statement
        $query = "SELECT p.*, c.name, c.abbreviation, c.start_date, t.topic_name FROM papers p " .
        "INNER JOIN conferences c ON p.conference_id = c.conference_id " . 
        "INNER JOIN topics t ON p.topic_id = t.topic_id " . 
        "LIMIT ? OFFSET ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $per_page, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $papers = $result->fetch_all(MYSQLI_ASSOC);
        
        // Đóng statement và kết nối
        $stmt->close();
        $db->close();
        
        return $papers;
    }
    
    public static function getTotalPages($per_page) {
        $db = getDB();
        
        // Lấy tổng số dòng dữ liệu
        $sql_count = "SELECT COUNT(*) AS total_rows FROM papers";
        $count_result = $db->query($sql_count);
        $total_rows = $count_result->fetch_assoc()['total_rows'];
        
        // Tính toán số trang
        $total_pages = ceil($total_rows / $per_page);
        
        // Đóng kết nối
        $db->close();
        
        return $total_pages;
    }

    public static function searchByAjax($keyword)
    {
        $db = getDB();
        // Câu truy vấn SQL
        $sql = "SELECT p.*, c.name, c.abbreviation, c.start_date, t.topic_name " .
            "FROM papers p " .
            "INNER JOIN conferences c ON p.conference_id = c.conference_id " .
            "INNER JOIN topics t ON p.topic_id = t.topic_id " .
            "WHERE p.title LIKE '%{$keyword}%' " .
            "OR p.author_string_list LIKE '%{$keyword}%' " .
            "OR c.name LIKE '%{$keyword}%' " .
            "OR c.abbreviation LIKE '%{$keyword}%' " .
            "OR c.start_date LIKE '%{$keyword}%' " .
            "OR t.topic_name LIKE '%{$keyword}%' " ;

        // Thực thi truy vấn SQL
        $result = mysqli_query($db, $sql);

        // Kiểm tra và hiển thị kết quả
        if(mysqli_num_rows($result) > 0) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Tác giả</th>
                        <th>Tóm tắt</th>
                        <th>Tên Hội Nghị</th>
                        <th>Tên Viết Tắt Hội Nghị</th>
                        <th>Ngày Bắt Đầu</th>
                        <th>Chủ Đề</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $paper_id = htmlspecialchars($row["paper_id"]);
                        $title = htmlspecialchars($row["title"]);
                        $author_string_list = htmlspecialchars($row["author_string_list"]);
                        $abstract = htmlspecialchars($row["abstract"]);
                        $name = htmlspecialchars($row["name"]);
                        $abbreviation = htmlspecialchars($row["abbreviation"]);
                        $start_date = htmlspecialchars($row["start_date"]);
                        $topic_name = htmlspecialchars($row["topic_name"]);
                        ?>
                        <tr onclick="window.location.href='index.php?action=paperDetail&paper_id=<?php echo $paper_id; ?>'">
                            <td><?php echo $title; ?></td>
                            <td><?php echo $author_string_list; ?></td>
                            <td><?php echo $abstract; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $abbreviation; ?></td>
                            <td><?php echo $start_date; ?></td>
                            <td><?php echo $topic_name; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            
            <style>
                table {
                    border-collapse: collapse;
                    width: 90vw;
                    padding: 0 10px;
                }
                thead {
                    background-color: #0e3746;
                    color: white;
                }
                tr {
                    cursor: pointer;
                }
                tr:hover {
                    background-color: #636363;
                    color: white;
                }
                th, td {
                    text-align: left;
                    padding: 8px;
                    border-bottom: 0.5px solid #0e3746;
                }
            </style>
            <?php
        } else {
            echo "<i><h6 style=\"color: red;\">Không tìm thấy bài báo nào</h6></i>";
        }
    }

    public static function find($id) {
        $db = getDB();
        $sql = "SELECT DISTINCT p.*, pa.role, pa.date_added, pa.status " . 
        "FROM PAPERS p ".
        "INNER JOIN PARTICIPATION pa ON p.paper_id = pa.paper_id ".
        "WHERE pa.author_id = ? ".
        "ORDER BY pa.date_added DESC";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }
        return $papers;
    }

    public static function getAllInforAPaper($paper_id) {
        $db = getDB();
        $sql = "SELECT p.title, p.abstract, t.topic_name, c.name, c.abbreviation, c.rank, c.start_date, c.end_date, c.type ".
        "FROM papers p ".
        "INNER JOIN conferences c ON p.conference_id = c.conference_id " .
        "INNER JOIN topics t ON p.topic_id = t.topic_id " .
        "WHERE p.paper_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $paper_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getAllParticipation($paper_id) {
        $db = getDB();
        $sql = "SELECT pa.author_id, pa.role, a.full_name ".
        "FROM papers p ".
        "INNER JOIN participation pa ON pa.paper_id = p.paper_id ".
        "INNER JOIN authors a ON a.user_id = pa.author_id " .
        "WHERE pa.status = 'show' AND p.paper_id = ? ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $paper_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $participants = [];
        while ($row = $result->fetch_assoc()) {
            $participants[] = $row;
        }
        return $participants;
    }
    // Hàm thêm sự tham gia của tác giả vào bài báo
    public static function addParticipant($author_id, $paper_id, $role) {
        $db = getDB();
        $date_added = date('Y-m-d H:i:s');
        $status = 'show';
        $query = "INSERT INTO PARTICIPATION (author_id, paper_id, role, date_added, status) VALUES (?, ?, ?, ?, ?)";

        $stmt = $db->prepare($query);
        $stmt->bind_param('iisss', $author_id, $paper_id, $role, $date_added, $status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Hàm xóa sự tham gia của tác giả khỏi bài báo
    public static function deleteParticipant($author_id, $paper_id) {
        $db = getDB();
        $query = "DELETE FROM PARTICIPATION WHERE author_id = ? AND paper_id = ?";

        $stmt = $db->prepare($query);
        $stmt->bind_param('ii', $author_id, $paper_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkAuthor($paper_id, $user_id) {
        $user_id = (int)$user_id;
        $db = getDB();
        $sql = "SELECT pa.role ".
        "FROM papers p ".
        "INNER JOIN participation pa ON pa.paper_id = p.paper_id ".
        "INNER JOIN authors a ON a.user_id = pa.author_id " .
        "INNER JOIN users u ON u.user_id = a.user_id " .
        "WHERE p.paper_id = ? AND u.user_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $paper_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public static function addPaper($title, $abstract, $conference_id, $topic_id, $user_id) {
        $db = getDB();
        $sql = "INSERT INTO papers (title, abstract, conference_id, topic_id, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ssiii', $title, $abstract, $conference_id, $topic_id, $user_id);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public static function updatePaperAuthors($paper_id, $author_string_list) {
        $db = getDB();
        $sql = "UPDATE PAPERS SET author_string_list = ? WHERE paper_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('si', $author_string_list, $paper_id);
        $stmt->execute();
        return $stmt->update_id;
    }
}
?>