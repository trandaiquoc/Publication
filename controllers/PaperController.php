<?php
require_once('models/Papers.php');
require_once('models/Authors.php');
require_once('models/Conferences.php');
require_once('models/Topics.php');
require_once('Controller.php');

class PaperController extends Controller {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?action=login');
            exit;
        }
        if (isset($_GET['paper_id']))
        {
            $paper_id = $_GET['paper_id'];
            $paper = Papers::getAllInforAPaper($paper_id);
            $participants = Papers::getAllParticipation($paper_id);
            $author = Papers::checkAuthor($paper_id, (int)$_SESSION['user']['user_id']);
            $this->loadView('view_paper.php', [
                'paper' => $paper,
                'participants' => $participants,
                'paper_id' => $paper_id,
                'author' => $author
            ]);
        }
        else
        {
            $this->loadView('error.php');
        }
    }

    public function addParticipant() {
        if (isset($_POST['paper_id']) && isset($_SESSION['user']['user_id'])) {
            $author = Authors::getAuthorByUserId($_SESSION['user']['user_id']);
            $paper_id = $_POST['paper_id'];
            $result = Papers::addParticipant($author['user_id'], $paper_id, 'member');

            if ($result) {
                $_SESSION['addmemberstatus'] = True;
            } else {
                $_SESSION['addmemberstatus'] = False;
            }

            header("Location: index.php?action=paperDetail&paper_id=" . $paper_id);
            exit();
        }
    }

    public function deleteParticipant() {
        if (isset($_POST['paper_id']) && isset($_POST['author_id'])) {
            $author_id = $_POST['author_id'];
            $paper_id = $_POST['paper_id'];
            $result = Papers::deleteParticipant($author_id, $paper_id);

            if ($result) {
                $_SESSION['deletestatus'] = True;
            } else {
                $_SESSION['deletestatus'] = False;
            }

            header("Location: index.php?action=paperDetail&paper_id=" . $paper_id);
            exit();
        }
    }

    public function addForm() {
        $this->loadView('add_paper.php');
    }

    public function addPaper() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $abstract = $_POST['abstract'];
            $conference_id = $_POST['conference_id'];
            $topic_id = $_POST['topic_id'];
            $author_ids = $_POST['author_id'];

            $first_author = Authors::getAuthorByUserId($_SESSION['user']['user_id']);
            $first_author_id = $first_author['user_id'];
            $author_names = [$first_author['full_name']];

            $paper_id = Papers::addPaper($title, $abstract, $conference_id, $topic_id, $first_author_id);
            Papers::addParticipant($first_author_id, $paper_id, 'first_author');
            foreach ($author_ids as $author_id) {
                Papers::addParticipant($author_id, $paper_id, 'member'); // Default role as member
                // Get author name and add to array
                $author = Authors::getAuthorByUserId($author_id);
                $author_names[] = $author['full_name'];
            }

            // Create author_string_list by joining names with commas
            $author_string_list = implode(', ', $author_names);

            // Update paper with author_string_list
            Papers::updatePaperAuthors($paper_id, $author_string_list);

            header('Location: index.php?action=paperDetail&paper_id=' . $paper_id);
        }
    }

    public function getConferences() {
        $conferences = Conferences::getAllConferences();
        echo json_encode($conferences);
    }

    public function getTopics() {
        $topics = Topics::getAllTopics();
        echo json_encode($topics);
    }

    public function getAuthors() {
        $author = Authors::getAuthorByUserId($_SESSION['user']['user_id']);
        $author_id = $author['user_id'];
        $authors = Authors::getAllAuthors($author_id);
        echo json_encode($authors);
    }
}