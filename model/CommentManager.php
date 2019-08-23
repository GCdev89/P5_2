<?php
namespace Gaetan\P5\Model;

require_once('../model/Manager.php');
require_once('../model/Comment.php');

class CommentManager extends Manager
{

    public function add(Comment $comment)
    {
        $q = $this->db()->prepare('INSERT INTO post_comment(user_id, post_id, title, content, date) VALUES(:user_id, :post_id, :title, :content, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $comment->userId(),
            'post_id' => $comment->postId(),
            'title' => $comment->title(),
            'content' => $comment->content(),
        ));
        return $affectedLines;
    }

    public function getComment($commentId)
    {
        $q = $this->db()->prepare('SELECT id, user_id userId, post_id postId, title, content, report, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM post_comment WHERE id = :id');
        $q->execute(array('id' => $commentId));
        $data = $q->fetch();
        $comment = new Comment($data);
        $q->closeCursor();

        return $comment;
    }

    public function getListComments($postId, $start, $commentsByPage)
    {
        $comments = [];

        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, c.id id, c.user_id userId, c.post_id postId, c.title title, c.content content, c.report report, DATE_FORMAT(c.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN post_comment c
            ON c.user_id = u.id
        WHERE c.post_id = :post_id
        ORDER BY c.date DESC
        LIMIT :start, :comments_by_page');
        $q->bindValue(':post_id', $postId, $this->db()::PARAM_INT);
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

        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, c.id id, c.user_id userId, c.post_id postId, c.title title, c.content content, c.report report, DATE_FORMAT(c.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN post_comment c
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
        $q = $this->db()->prepare('UPDATE post_comment SET title = :newtitle, content = :newcontent WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newtitle' => $comment->title(),
            'newcontent' => $comment->content(),
            'id' => $comment->id()
        ));
        return $affectedLines;
    }

    public function report(Comment $comment)
    {
        $q = $this->db()->prepare('UPDATE post_comment SET report = :newreport WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newreport' => $comment->report(),
            'id' => $comment->id()
        ));
        return $affectedLines;
    }

    public function delete($commentId)
    {
        $q = $this->db()->prepare('DELETE FROM post_comment WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $commentId));

        return $affectedLines;
    }

    public function deletePostComments($postId)
    {
        $q = $this->db()->prepare('DELETE FROM post_comment WHERE post_id = :post_id');
        $commentsDeleted = $q->execute(array('post_id' => $postId));

        return $commentsDeleted;
    }

    public function deleteUserComments($userId)
    {
        $q = $this->db()->prepare('DELETE FROM post_comment WHERE user_id = :user_id');
        $commentsDeleted = $q->execute(array('user_id' => $userId));

        return $commentsDeleted;
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM post_comment WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    public function count($postId)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) AS count FROM post_comment WHERE post_id = :post_id');
        $q->execute(array('post_id' => $postId));
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
