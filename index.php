<?php
session_start();
require_once('config/config.inc.php');

function autoloadMVC($directory)
{
    foreach (glob($directory . '/*.php') as $filename) {
        require_once($filename);
    }
}

autoloadMVC('models');
autoloadMVC('controllers');
$action = "";
if (isset($_REQUEST["action"]))
{
    $action = $_REQUEST["action"];
}

switch($action)
{
    case "home":
        $controller = new HomeController();
        $controller->index();
        break;
    case "search":
        $controller = new SearchController();
        $controller->index();
        break;
    case "searchAjax":
        $controller = new SearchController();
        $controller->search();
        break;
    case "login":
        $controller = new UserController();
        $controller->index();
        break;
    case "logout":
        $controller = new UserController();
        $controller->logout();
        break;
    case "viewprofile":
        $controller = new AuthorController();
        $controller->index();
        break;
    case "checkOthers":
        $controller = new AuthorController();
        $controller->checkOthers();
        break;
    case "editprofile":
        $controller = new AuthorController();
        $controller->edit();
        break;
    case "paperDetail":
        $controller = new PaperController();
        $controller->index();
        break;
    case "addParticipant":
        $controller = new PaperController();
        $controller->addParticipant();
        break;
    case "deleteParticipant":
        $controller = new PaperController();
        $controller->deleteParticipant();
        break;
    case "changeStatus":
        $controller = new AuthorController();
        $controller->changeStatus();
        break;
    case "addForm":
        $controller = new PaperController();
        $controller->addForm();
        break;
    case "addPaper":
        $controller = new PaperController();
        $controller->addPaper();
        break;
    case "getConferences":
        $controller = new PaperController();
        $controller->getConferences();
        break;
    case "getTopics":
        $controller = new PaperController();
        $controller->getTopics();
        break;
    case "getAuthors":
        $controller = new PaperController();
        $controller->getAuthors();
        break;
    case "":
        $controller = new HomeController();
        $controller->index();
        break;
    default:
        include('views/error.php');
        break;
}
?>
