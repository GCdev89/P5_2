<?php
namespace Gaetan\P5\Model;

require_once('../model/Manager.php');
require_once('../model/Post.php');

class PostManager extends Manager
{
    public function add(Post $post)
    {
        $q = $this->db()->prepare('INSERT INTO post(user_id, title, content, meta_title, meta_desc, date) VALUES(:user_id, :title, :content, :meta_title, :meta_desc, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $post->userId(),
            'title' => $post->title(),
            'content' => $post->content(),
            'meta_title' => $post->metaTitle(),
            'meta_desc' => $post->metaDesc()
        ));
        return $affectedLines;
    }

    public function update(Post $post)
    {
        $q = $this->db()->prepare('UPDATE post SET  title = :newtitle, content = :newcontent, meta_title = :newmeta_title, meta_desc = :newmeta_desc WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newtitle' => $post->title(),
            'newcontent' => $post->content(),
            'newmeta_title' => $post->metaTitle(),
            'newmeta_desc' => $post->metaDesc(),
            'id' => $post->id()
        ));
        return $affectedLines;
    }

    public function getPost($postId)
    {
        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, p.id id, p.user_id userId, p.title title, p.content content, p.meta_title metaTitle, p.meta_desc metaDesc, DATE_FORMAT(p.date, \'%d/%m/%Y à %Hh%imin%ss\') AS date
        FROM user u
        INNER JOIN post p
        ON p.user_id = u.id
        WHERE p.id = :id');
        $q->execute(array('id' => $postId));
        $data = $q->fetch();

        $post = new Post($data);
        $q->closeCursor();

        return $post;
    }

    public function getListPosts($start, $postsByPage, $whereUser)
    {
        $query = 'SELECT u.pseudo userPseudo, p.id id, p.user_id userId, p.title title, p.content content, p.meta_title metaTitle, p.meta_desc metaDesc, DATE_FORMAT(p.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN post p
            ON p.user_id = u.id
        ';
        $where = '';
        // Filter by user if $whereUser == true
        if ($whereUser > 0) {
            $where = 'WHERE p.user_id = :user_id ';
        }

        $query .= $where;
        $query .= 'ORDER BY p.date DESC
        LIMIT :start, :posts_by_page';

        $q = $this->db()->prepare($query);
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':posts_by_page', $postsByPage, $this->db()::PARAM_INT);
        if ($whereUser > 0) {
            $q->bindValue(':user_id', $whereUser, $this->db()::PARAM_STR);
        }

        $q->execute();
        $posts = [];
        while($data = $q->fetch())
        {
            $posts[] = new Post($data);
        }
        $q->closeCursor();

        return $posts;

    }

    public function delete($postId)
    {
        $q = $this->db()->prepare('DELETE FROM post WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $postId));

        return $affectedLines;
    }

    public function count($userId)
    {
        $query = 'SELECT COUNT(id) FROM post';
        $where = '';
        if ($userId > 0) {
            $where = ' WHERE user_id = :user_id';
        }
        $query .= $where;
        $q= $this->db()->prepare($query);
        if ($userId > 0) {
            $q->bindValue(':user_id', $userId, $this->db()::PARAM_INT);
        }
        $q->execute();
        return $postCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM post WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    /*public function setDb()
    {
        $db = $this->dbConnect();
        $this->_db = $db;
    }*/
}
