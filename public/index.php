<?php

require ('../controller/frontend.php');
require ('../controller/backend.php');
require ('../controller/Session.php');
require ('../controller/Check.php');



try {
    session_start();

    /*
    * Manage posts and comments view using frontend controller and backend controller to insert/update/delete from db
    */
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'home') {
            homePage();
        }
        elseif ($_GET['action'] == 'list_articles') {
            $parent = Check::wichParent();
            $tag = Check::wichTag();
            listContents($content = 'article', $parent, $tag);
        }
        elseif ($_GET['action'] == 'list_posts') {
            listContents($content = 'post', $parents = NULL, $tag = NULL);
        }
        elseif ($_GET['action'] == 'article')
        {
            if (Check::isIdSet()) {
                getContent($type = 'article', $_GET['id']);
            }
            else {
                throw new Exception('Aucun idenditifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'post')
        {
            if (Check::isIdSet()) {
                getContent($type = 'post', $_GET['id']);
            }
            else {
                throw new Exception('Aucun idenditifiant de billet envoyé');
            }
        }
        // Will use backend controller to manage db
        elseif ($_GET['action'] == 'addComment') {
            if (Check::commentFormOk()) {
                addComment($_POST, Session::getUserId(), Session::getUserPseudo());
            }
            else {
                throw new Exception('Tous les champs ne sont pas remplis.');
            }
        }
        elseif ($_GET['action'] == 'comment_edit' && isset($_SESSION['user_id']))
        {
            if (Check::isIdSet())
            {
                updateComment($_GET['id'], Session::getUserId());
            }
            else {
                throw new Exception('Aucun identifiant de commentaires envoyé');
            }
        }
        elseif ($_GET['action'] == 'comment_updated')
        {
            if (Check::commentFormOk()) {
                updatedComment($_POST, Session::getUserId());
            }
            else {
                throw new Exception('Tous les champs ne sont pas correctement remplis.');
            }
        }
        elseif ($_GET['action'] == 'delete_comment') {
            if (Check::isIdSet()) {
                if (Session::getUserId() > 0) {
                    deleteComment(Session::getUserId(), $_GET['id']);
                }
                else {
                    throw new Exception('Vous n\'avez pas l\'autorisation requise');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'report') {
            if (Session::getUserId() > 0 && Check::isIdSet()) {
                report($_GET['id'], Session::getUserId());
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        /*
        * User management using controller frontend to set up the views and backend for insert to db
        */
        elseif ($_GET['action'] == 'registration')
        {
            if ($_GET['sent'] == 'no') {
                registration();
            }
            elseif ($_GET['sent'] == 'yes')
            {
                if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
                {
                    if ($_POST['password'] == $_POST['confirm_password'])  {
                        addUser($_POST['pseudo'], $_POST['password'], $_POST['mail']);
                    }
                    else
                    {
                        throw new Exception('Merci de confirmer le mot de passe.');
                    }
                }
                else {
                    throw new Exception('Veuillez remplir les informations requises pour l\'inscription');
                }
            }
            else {
                registration();
            }
        }
        elseif ($_GET['action'] == 'registered') {
            registered();
        }
        elseif ($_GET['action'] == 'connect') {
            if (!empty($_POST['pseudo']) && !empty($_POST['password']))
            {
                connection($_POST['pseudo'], $_POST['password']);
            }
            else
            {
                throw new Exception('Merci de renseigner un pseudo et un mot de passe valide.');
            }
        }
        elseif ($_GET['action'] == 'disconnect')
        {
            disconnect();
        }
        elseif ($_GET['action'] == 'user_profile') {
            if (isset($_SESSION['user_id'])) {
                userProfile($_SESSION['user_id']);
            }
            else {
                throw new Exception('Vous n\'êtes pas connecté.');
            }
        }
        elseif ($_GET['action'] == 'update_mail') {
            if (isset($_SESSION['user_id']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
                updateMail($_SESSION['user_id'], $_POST['mail'], $_POST['password']);
            }
            else {
                throw new Exception('Merci remplir tous les champs.');
            }
        }
        elseif ($_GET['action'] == 'update_password') {
            if (isset($_SESSION['user_id']) && !empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
                if ($_POST['new_password'] == $_POST['confirm_new_password']) {
                    updatePassword($_SESSION['user_id'], $_POST['password'], $_POST['new_password']);
                }
                else {
                    throw new Exception('Merci de vérifier les informations que vous avez saisi.');
                }
            }
            else {
                throw new Exception('Merci remplir tous les champs.');
            }
        }
        /*
        * Control session role. If admin is set up, grant privileges to admin pannel
        */
        // Writer, Editor, Admin
        elseif ($_GET['action'] == 'new') {
            if (Session::hasWriteAccess()) {
                newPost();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'add_article') {
            if (Session::hasWriteAccess()) {
                if (Check::articleFormOk()) {
                    addArticle($_POST);
                }
                else {
                    throw new Exception('Merci de remplir tous les champs');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise. 1');
            }
        }
        elseif ($_GET['action'] == 'update_list_my_contents') {
            if (Session::hasWriteAccess()) {
                $type = Check::wichType();
                $tag = Check::wichTag();
                $allContents = false;
                if ($type == 'article') {
                    updateListContents($type, $allContents, $tag);
                }
                elseif ($type == 'post') {
                    if (Session::hasAdminAccess()) {
                        updateListContents($type, $allContents, $tag);
                    }
                    else {
                        throw new Exception('Vous n\'avez pas l\'autorisation requise. 5');
                    }
                }
                else {
                    $type = 'article';
                    updateListContents($type, $allContents, $tag);
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'update_content') {
            if (Session::hasWriteAccess()) {
                if (Check::isIdSet()) {
                    $type = Check::wichType();
                    if ($type =='article') {
                        updateContent($type, $_GET['id']);
                    }
                    else {
                        if (Session::hasAdminAccess()) {
                            updateContent($type, $_GET['id']);
                        }
                        else {
                            throw new Exception('Vous n\'avez pas l\'autorisation requise');
                        }
                    }
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'updated_article') {
            if (Session::hasWriteAccess()) {
                if (isset($_POST['content_id']) && Check::articleFormOk()) {
                    updatedArticle($_POST);
                }
                else {
                    throw new Exception('Merci de remplir tous les champs.');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        // Editor and Admin
        elseif ($_GET['action'] == 'update_list_contents') {
            if (Session::hasEditionAccess()) {
                $allContents = true;
                $tag = Check::wichTag();
                    updateListContents( $type = 'article', $allContents, $tag);
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'delete_content') {
            if (Session::hasEditionAccess()) {
                if (Check::isIdSet()) {
                    $type = Check::wichType();
                    if ($type == 'article') {
                        deleteContent(Session::getUserId(), $_GET['id'], $type);
                    }
                    elseif ($type == 'post') {
                        if (Session::hasAdminAccess()) {
                            deleteContent(Session::getUserId(), $_GET['id'], $type);
                        }
                    }
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        // Moderator and Admin
        elseif ($_GET['action'] == 'moderation') {
            if (Session::hasModerationAccess()) {
                moderation();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'ignore') {
            if (Session::hasModerationAccess()) {
                if (Check::isIdSet()) {
                    ignoreComment($_GET['id']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'delete_reported') {
            if (Session::hasModerationAccess()) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    deleteReported($_GET['id']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'users_list') {
            if (Session::hasModerationAccess()) {
                usersList();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == "delete_user") {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if ($_SESSION['role'] == 'admin') {
                    deleteUser($_GET['id']);
                }
                elseif ($_SESSION['role'] == 'moderator') {
                    deleteCommonUser($_GET['id']);
                }
                else {
                    throw new Exception('Vous n\'avez pas l\'autorisation requise');
                }
            }
            else {
                throw new Exception('Aucun identifiant envoyé');
            }
        }
        // Admin
        elseif ($_GET['action'] == 'update_role') {
            if (Session::hasAdminAccess()) {
                if (!empty($_POST['user_id']) && $_POST['user_id'] > 0 && !empty($_POST['role'])) {
                    updateRole($_POST['user_id'], $_POST['role']);
                }
                else {
                    throw new Exception('Aucune donnée de formulaire envoyée');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'add_post') {
            if (Session::hasAdminAccess()) {
                if (Check::postFormOk()) {
                    addPost(Session::getUserId(), $_POST['post_title'], $_POST['post_meta_title'], $_POST['post_meta_desc'], $_POST['post_content']);
                }
                else {
                    throw new Exception('Merci de remplir tous les champs.');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'updated_post') {
            if (Session::hasAdminAccess()) {
                if (isset($_POST['content_id']) && Check::postFormOk()) {
                    updatedPost($_POST['content_id'], $_POST['post_title'], $_POST['post_meta_title'], $_POST['post_meta_desc'], $_POST['post_content']);
                }
                else {
                    throw new Exception('Merci de remplir tous les champs.');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        else {
            homePage();;
        }
    }
    else {
        homePage();;
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('../view/errorView.php');
}
