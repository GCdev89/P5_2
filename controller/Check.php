<?php
class Check
{
    public static function wichParent()
    {
        if (isset($_GET['parent'])) {
            if ($_GET['parent'] == 'both' OR $_GET['parent'] == 'dad' OR $_GET['parent'] == 'mom') {
                return $_GET['parent'];
            }
            else {
                return 'both';
            }
        }
        else {
            return 'both';
        }
    }

    public static function wichTag()
    {
        if(isset($_GET['tag'])) {
            switch ($_GET['tag']) {
                case 'house':
                    return $_GET['tag'];
                    break;
                case 'baby':
                    return $_GET['tag'];
                    break;
                case 'pregnancy':
                    return $_GET['tag'];
                    break;
                default:
                    return NULL;
                    break;
            }
        }
    }

    public static function isIdSet()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function wichType()
    {
        if (isset($_GET['type'])) {
            if ($_GET['type'] == 'post' OR $_GET['type'] == 'article') {
                if ($_GET['type'] == 'post' ) {
                    return $_GET['type'];
                }
                elseif ($_GET['type'] == 'article') {
                    return $_GET['type'];
                }
                else {
                    return 'article';
                }
            }
            else {
                return NULL;
            }
        }
        else {
            return NULL;
        }
    }

    public static function postFormOk()
    {
        if (!empty($_POST['post_title']) && !empty($_POST['post_meta_title']) && !empty($_POST['post_meta_desc']) && !empty($_POST['post_content'])) {
            return true;
        }
        else {
            return false;
        }
    }


    public static function articleFormOk()
    {
        if (!empty($_POST['parent']) && !empty($_POST['tag']) && !empty($_POST['article_title']) && isset($_POST['description']) && !empty($_POST['article_meta_title']) && !empty($_POST['article_meta_desc']) && !empty($_POST['article_content'])) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function commentFormOk()
    {
        if (!empty($_SESSION['user_id']) && !empty($_POST['comment']) && !empty($_SESSION['pseudo']) && !empty($_POST['type']) && !empty($_POST['content_id'])) {
            if ($_POST['type'] == 'post' OR $_POST['type'] == 'article') {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public static function updateCommentFormOk()
    {
        if (!empty($_SESSION['user_id']) && !empty($_POST['comment']) && !empty($_SESSION['pseudo']) && !empty($_POST['type']) && !empty($_POST['content_id'])) {
            return true;
        }
        else {
            return false;
        }
    }
}
