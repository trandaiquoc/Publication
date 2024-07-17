<?php
require_once('models/Topics.php');
require_once('models/Papers.php');

class HomeController extends Controller {
    public function index() {
        $topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : 1;
        $topic_name = isset($_GET['topic_name']) ? $_GET['topic_name'] : 'Artificial Intelligence';
        $papers = Papers::getTop5PapersByTopic($topic_id);
        $this->loadView('home.php', ['papers' => $papers, 'topic_id' => $topic_id, 'topic_name' => $topic_name]);
    }
}
?>
