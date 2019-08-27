<?php
/*
* Manage views that must be returned to the user, reading the DB
*/
require_once('../model/PostManager.php');
require_once('../model/CommentManager.php');
require_once('../model/UserManager.php');
require_once('../model/ArticleManager.php');


/*
* Set frontoffice view if conditions are correct
*/
function homePage()
{
    $isActive = 'home';
    require('../view/frontoffice/headerView.php');
    require('../view/frontoffice/homeView.php');
}
function listContents($content, $parent, $tag)
{
    if ($content == 'article') {
        $contentManager = new Gaetan\P5_2\Model\ArticleManager();
        $contentsByPage = 6;
        $view = '../view/frontoffice/listArticlesView.php';
        $action = 'list_articles';
        $isActive = $parent;
        require('../view/frontoffice/sidebar.php');
    }
    elseif ($content == 'post') {
        $contentManager = new Gaetan\P5_2\Model\PostManager();
        $contentsByPage = 3;
        $view = '../view/frontoffice/listPostsView.php';
        $action = 'list_posts';
        $isActive = 'blog';
    }
    $userId = 0;
    $contentCount = $contentManager->count($userId);
    $countPages = ceil($contentCount / $contentsByPage);
    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $contentsByPage;
    $whereUser = 0;
    $contents = $contentManager->getList($start, $contentsByPage, $whereUser, $parent, $tag);
    $action = 'list_posts';
    require('../view/pagination.php');
    require($view);
}

function getContent($type, $contentId)
{
    if ($type == 'article') {
        $contentManager = new Gaetan\P5_2\Model\ArticleManager();
        $view = '../view/frontoffice/articleView.php';
    }
    elseif ($type == 'post') {
        $contentManager = new Gaetan\P5_2\Model\PostManager();
        $view = '../view/frontoffice/postView.php';
    }
    $commentManager = new Gaetan\P5_2\Model\CommentManager();
    if ($contentManager->exists($contentId)) {
        $thisContent = $contentManager->get($contentId);

        $commentsCount = $commentManager->count($contentId, $type);
        $commentsByPage = 10;
        $countPages = ceil($commentsCount / $commentsByPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
            $currentPage = intval($_GET['page']);
        }
        else {
            $currentPage = 1;
        }
        $start = ($currentPage - 1) * $commentsByPage;

        $comments = $commentManager->getListComments($contentId, $start, $commentsByPage, $type);
        $action = $type . '&amp;id=' . $contentId;

        require('../view/pagination.php');
        require($view);
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

function registration()
{
    require('../view/frontoffice/registrationView.php');
}

function registered()
{
    require('../view/frontoffice/registeredView.php');

}

function updateComment($commentId, $userId)
{
    $commentManager = new Gaetan\P5_2\Model\CommentManager();
    if ($commentManager->exists($commentId))
    {
        $comment = $commentManager->getComment($commentId);
        if ($comment->userId() == $userId) {
            require('../view/frontoffice/updateCommentView.php');
        }
        else {
            throw new Exception('Identifiant incorrect.1');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.2');
    }
}

function userProfile($userId)
{
    $userManager = new Gaetan\P5_2\Model\UserManager();
    if ($userManager->exists($userId)) {
        $user = $userManager->getUser($userId);
        require('../view/frontoffice/userProfileView.php');
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

/*
* Set backoffice view if conditions are verified
*/
// For writer, editor and admin
function newPost()
{
    $isActive = 'newPost';
    $postAction = 'add_post';
    $articleAction = 'add_article';
    require('../view/backoffice/postForm.php');
    require('../view/backoffice/articleForm.php');
    require('../view/backoffice/newPostView.php');
}

function updateContent($type, $contentId)
{
    if ($type == 'article') {
        $contentManager = new Gaetan\P5_2\Model\ArticleManager();
    }
    else {
        $contentManager = new Gaetan\P5_2\Model\PostManager();
    }
    if ($contentManager->exists($contentId))
    {
        if (Session::hasWriteAccess()) {
            $thisContent = $contentManager->get($contentId);
            if ($thisContent->userId() == $_SESSION['user_id']) {
                if ($type == 'article') {
                    $articleAction = 'updated_article';
                    require('../view/backoffice/articleForm.php');
                }
                elseif ($type == 'post') {
                    $postAction = 'updated_post';
                    require('../view/backoffice/postForm.php');
                }
                require('../view/backoffice/updateContentView.php');
            }
            else {
                throw new Exception('Identifiant incorrect.');
            }
        }
        else {
            $content = $contentManager->get($contentId);
            require('../view/backoffice/articleForm.php');
            require('../view/backoffice/updateContentView.php');
        }
    }
    else {
        throw new Exception('Identifiant de billet incorrect.');
    }
}

// For editor and admin
function updateListContents($type, $allContents, $tag)
{
    // Test condition, either return all posts, or just those specific to one user
    if ($allContents == false) {
        $userId = Session::getUserId();
        $whereUser = $userId;
        $isActive = 'myContents';
        $action = 'update_list_my_contents';
    }
    else {
        $userId = 0;
        $whereUser = 0;
        $isActive = 'allContents';
        $action = 'update_list_contents';
    }
    if ($type == 'article' OR $type == NULL) {
        $contentManager = new Gaetan\P5_2\Model\ArticleManager();
        $contentsByPage = 10;
    }
    elseif ($type == 'post') {
        $contentManager = new Gaetan\P5_2\Model\PostManager();
        $contentsByPage = 10;
    }
    $contentCount = $contentManager->count($userId, $type);
    $countPages = ceil($contentCount / $contentsByPage);
    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $contentsByPage;
    $parent = NULL;
    $contents = $contentManager->getList($start, $contentsByPage, $whereUser, $parent, $tag);
    require('../view/paginationByType.php');
    require('../view/backoffice/updateListView.php');
}

// For moderator and admin
function moderation()
{
    $commentManager = new Gaetan\P5_2\Model\CommentManager();
    $reportCount = $commentManager->countReport();
    $reportsByPage = 10;
    $countPages = ceil($reportCount / $reportsByPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $reportsByPage;

    $comments = $commentManager->getReportedList($start, $reportsByPage);
    $action = 'moderation';
    $isActive = 'moderation';

    require('../view/pagination.php');
    require('../view/backoffice/moderationView.php');
}

function usersList()
{
    $userManager = new Gaetan\P5_2\Model\UserManager();
    $usersCount =$userManager->count();
    $usersByPage = 20;
    $countPages = ceil($usersCount / $usersByPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $usersByPage;
    $users = $userManager->getListUsers($start, $usersByPage);

    $action = 'users_list';
    $isActive = 'users';

    require('../view/pagination.php');
    if ($_SESSION['role'] == 'admin') {
        require('../view/backoffice/listUsersAdminView.php');
    }
    else {
        require('../view/backoffice/listUsersView.php');
    }
}
