<?php
namespace Gaetan\P5_2\Model;

require_once('../model/Manager.php');
require_once('../model/Article.php');

class ArticleManager extends Manager
{
    public function add(Article $article)
    {
        $q = $this->db()->prepare('INSERT INTO article(user_id, title, content, description, parent, tag, meta_title, meta_desc, date) VALUES(:user_id, :title, :content, :description, :parent, :tag, :meta_title, :meta_desc, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $article->userId(),
            'title' => $article->title(),
            'content' => $article->content(),
            'description' => $article->description(),
            'parent' => $article->parent(),
            'tag' => $article->tag(),
            'meta_title' => $article->metaTitle(),
            'meta_desc' => $article->metaDesc()
        ));
        return $affectedLines;
    }

    public function update(Article $article)
    {
        $q = $this->db()->prepare('UPDATE article SET  title = :newtitle, content = :newcontent, description = :newdescription, parent = :newparent, tag = :newtag, meta_title = :newmeta_title, meta_desc = :newmeta_desc WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newtitle' => $article->title(),
            'newcontent' => $article->content(),
            'newdescription' => $article->description(),
            'newparent' => $article->parent(),
            'newtag' => $article->tag(),
            'newmeta_title' => $article->metaTitle(),
            'newmeta_desc' => $article->metaDesc(),
            'id' => $article->id()
        ));
        return $affectedLines;
    }

    public function get($articleId)
    {
        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, a.id id, a.user_id userId, a.title title, a.content content, a.description description, a.parent parent, a.tag tag, a.meta_title metaTitle, a.meta_desc metaDesc, DATE_FORMAT(a.date, \'%d/%m/%Y à %Hh%imin%ss\') AS date
        FROM user u
        INNER JOIN article a
        ON a.user_id = u.id
        WHERE a.id = :id');
        $q->execute(array('id' => $articleId));
        $data = $q->fetch();

        $article = new article($data);
        $q->closeCursor();

        return $article;
    }

    public function getList($start, $articlesByPage, $whereUser, $parent, $tag)
    {
        $query = 'SELECT u.pseudo userPseudo, a.id id, a.user_id userId, a.title title, a.content content, a.description description, a.parent parent, a.tag tag, a.meta_title metaTitle, a.meta_desc metaDesc, DATE_FORMAT(a.date, \'%d/%m/%Y\') AS date
        FROM user u
        INNER JOIN article a
            ON a.user_id = u.id
        ';
        $where = '';
        // Filter by user if $whereUser == true
        if ($whereUser > 0) {
            $where = 'WHERE a.user_id = :user_id ';
        }
        // Filter by parent type
        if ($parent != NULL && $parent != 'both') {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where = 'WHERE';
            }
            $where .= ' (a.parent = :parent OR a.parent = "both") ';
        }

        // Filter by tag
        if ($tag != NULL) {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where = 'WHERE';
            }
            $where .= ' a.tag = :tag ';
        }
        $query .= $where;
        $query .= 'ORDER BY a.date DESC
        LIMIT :start, :articles_by_page';

        $q = $this->db()->prepare($query);
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':articles_by_page', $articlesByPage, $this->db()::PARAM_INT);
        if ($whereUser > 0) {
            $q->bindValue(':user_id', $whereUser, $this->db()::PARAM_INT);
        }
        if ($parent != NULL && $parent != 'both') {
            $q->bindValue(':parent', $parent, $this->db()::PARAM_STR);
        }
        if ($tag != NULL) {
            $q->bindValue(':tag', $tag, $this->db()::PARAM_STR);
        }

        $q->execute();
        $articles = [];
        while($data = $q->fetch())
        {
            $articles[] = new Article($data);
        }
        $q->closeCursor();

        return $articles;

    }

    public function delete($articleId)
    {
        $q = $this->db()->prepare('DELETE FROM article WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $articleId));

        return $affectedLines;
    }

    public function count($userId, $parent, $tag)
    {
        $query = 'SELECT COUNT(id) FROM article';
        $where = '';
        if ($userId > 0) {
            $where = ' WHERE user_id = :user_id';
        }
        if ($parent != NULL && $parent != 'both') {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where = ' WHERE';
            }
            $where .= ' (parent = :parent OR parent = "both")';
        }
        if ($tag != NULL) {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where .= ' WHERE';
            }
            $where .= ' tag = :tag';
        }
        $query .= $where;

        $q= $this->db()->prepare($query);
        if ($userId > 0) {
            $q->bindValue(':user_id', $userId, $this->db()::PARAM_INT);
        }
        if ($parent != NULL && $parent != 'both') {
            $q->bindValue(':parent', $parent, $this->db()::PARAM_STR);
        }
        if ($tag != NULL) {
            $q->bindValue(':tag', $tag, $this->db()::PARAM_STR);
        }
        $q->execute();
        return $articleCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM article WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }
}
