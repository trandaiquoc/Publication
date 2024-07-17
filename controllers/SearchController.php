<?php
require_once('models/Papers.php');

class SearchController extends Controller {

    public function index() {
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $per_page = 5;
        // Lấy dữ liệu từ model Papers
        $papers = Papers::getAll($current_page, $per_page);
        
        // Tính toán số trang
        $total_pages = Papers::getTotalPages($per_page);
        
        $this->loadView('search.php', [
            'papers' => $papers,
            'per_page' => $per_page,
            'current_page' => $current_page,
            'total_pages' => $total_pages
        ]);
    }
    
    public function search() {
        if(isset($_POST['input'])) {
            $keyword = htmlspecialchars($_POST['input']);
            Papers::searchByAjax($keyword);
        }
    }
}
?>