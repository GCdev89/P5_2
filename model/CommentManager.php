<?php
namespace Gaetan\P5_2\Model;

require_once('../model/Manager.php');
require_once('../model/Comment.php');

class CommentManager extends Manager
{

    public function add(Comment $comment)
    {

        $q = $this->db()->prepare('INSERT INTO comment(user_id, content_id, type, content, date) VALUES(:user_id, :content_id, :type, :content, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $comment->userId(),
            'content_id' => $comment->contentId(),
            'type' => $comment->type(),
            'content' => $comment->content()
        ));
        return $affectedLines;
    }

    public function getComment($commentId)
    {
        $q = $this->db()->prepare('SELECT id, user_id userId, content_id contentId, type, content, report, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM comment WHERE id = :id');
        $q->execute(array('id' => $commentId));
        $data = $q->fetch();
        $comment = new Comment($data);
        $q->closeCursor();

        return $comment;
    }

    public function getListComments($contentId, $start, $commentsByPage, $type)
    {
        $comments = [];

        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, c.id id, c.user_id userId, c.content_id contentId, c.type type, c.content content, c.report report, DATE_FORMAT(c.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN comment c
            ON c.user_id = u.id
        WHERE c.content_id = :content_id
        AND c.type = :type
        ORDER BY c.date DESC
        LIMIT :start, :comments_by_page');
        $q->bindValue(':content_id', (int)$contentId, $this->db()::PARAM_INT);
        $q->bindValue(':type', $type, $this->db()::PARAM_STR);
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':comments_by_page', $commentsByPage, $this->db()::PARAM_INT);
        $q->execute();
        while($data = $q->fetch())
        {
            $comments[] = new Comment($data);
        }
        $q->closeCursor();
        return $comments;
    }

    public function getReportedList($start, $reportsByPage)
    {
        $comments = [];

        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, c.id id, c.user_id userId, c.content_id contentId, c.type type, c.content content, c.report report, DATE_FORMAT(c.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN comment c
            ON c.user_id = u.id
        WHERE c.report >= 1
        ORDER BY c.report DESC
        LIMIT :start, :reports_by_page');
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':reports_by_page', $reportsByPage, $this->db()::PARAM_INT);
        $q->execute();
        while($data = $q->fetch())
        {
            $comments[] = new Comment($data);
        }
        $q->closeCursor();
        return $comments;
    }

    public function update(Comment $comment)
    {
        $q = $this->db()->prepare('UPDATE comment SET content = :newcontent WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newcontent' => $comment->content(),
            'id' => $comment->id()
        ));
        return $affectedLines;
    }

    public function report(Comment $comment)
    {
        $q = $this->db()->prepare('UPDATE comment SET report = :newreport WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newreport' => $comment->report(),
            'id' => $comment->id()
        ));
        return $affectedLines;
    }

    public function delete($commentId)
    {
        $q = $this->db()->prepare('DELETE FROM comment WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $commentId));

        return $affectedLines;
    }

    public function deleteContentComments($contentId, $type)
    {
        if ($type == 'article') {
            $commentTable = 'article_comment';
        }
        elseif ($type == 'post') {
            $commentTable = 'post_comment';
        }
        $q = $this->db()->prepare('DELETE FROM :comment_table WHERE post_id = :post_id');
        $q->bindValue(':comment_table', $commentTable, $this->db()::PARAM_STR);
        $q->bindValue(':post_id', $contentId, $this->db()::PARAM_INT);
        $commentsDeleted = $q->execute();

        return $commentsDeleted;
    }

    public function deleteUserComments($userId)
    {
        $q = $this->db()->prepare('DELETE FROM post_comment WHERE user_id = :user_id');
        $commentsPostDeleted = $q->execute(array('user_id' => $userId));
        $q2 = $this->db()->prepare('DELETE FROM article_comment WHERE user_id = :user_id');
        $commentsArticleDeleted = $q2->execute(array('user_id' => $userId));
        if ($commentsPostDeleted == true && $commentsArticleDeleted == true) {
            $commentsDeleted = true;
        }
        else {
            $commentsDeleted = false;
        }
        return $commentsDeleted;
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM comment WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    public function count($contentId, $type)
    {
        if ($type == 'article') {
            $q = $this->db()->prepare('SELECT COUNT(*) AS count FROM article_comment WHERE article_id = :article_id');
            $q->execute(array('article_id' => $contentId));
        }
        elseif ($type == 'post') {
            $q = $this->db()->prepare('SELECT COUNT(*) AS count FROM post_comment WHERE post_id = :post_id');
            $q->execute(array('post_id' => $contentId));
        }
        $data = $q->fetch();
        $q->closeCursor();
        $commentsCount = $data['count'];

        return $commentsCount;
    }

    public function countReport()
    {
        $q = $this->db()->query('SELECT COUNT(*) AS count_report FROM post_comment WHERE report >= 1 ');
        $data = $q->fetch();
        $q->closeCursor();
        $countReport = $data['count_report'];

        return $countReport;
    }
}
