<?php
namespace Gaetan\P5\Model;

require_once('../model/Manager.php');
require_once('../model/Article.php');

class ArticleManager extends Manager
{
    public function add(Article $article)
    {
        $q = $this->db()->prepare('INSERT INTO article(user_id, title, content, description, parent, tag_1, tag_2, tag_3, meta_title, meta_desc, date) VALUES(:user_id, :title, :content, :parent, :description, :tag_1, :tag_2, :tag_3, :meta_title, :meta_desc, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $article->userId(),
            'title' => $article->title(),
            'content' => $article->content(),
            'description' => $article->description(),
            'parent' => $article->parent(),
            'tag_1' => $article->tag_1(),
            'tag_2' => $article->tag_2(),
            'tag_3' => $article->tag_3(),
            'meta_title' => $article->metaTitle(),
            'meta_desc' => $article->metaDesc()
        ));
        return $affectedLines;
    }

    public function update(Article $article)
    {
        $q = $this->db()->prepare('UPDATE article SET  title = :newtitle, content = :newcontent, description = :newdescription, parent = :newparent, tag_1 = :newtag_1, tag_2 = :newtag_2, tag_3 = :newtag_3, meta_title = :newmeta_title, meta_desc = :newmeta_desc WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newtitle' => $article->title(),
            'newcontent' => $article->content(),
            'newdescription' => $article->description(),
            'newparent' => $article->parent(),
            'newtag_1' => $article->tag_1(),
            'newtag_2' => $article->tag_2(),
            'newtag_3' => $article->tag_3(),
            'newmeta_title' => $article->metaTitle(),
            'newmeta_desc' => $article->metaDesc(),
            'id' => $article->id()
        ));
        return $affectedLines;
    }

    public function get($articleId)
    {
        $q = $this->db()->prepare('SELECT u.pseudo userPseudo, a.id id, a.user_id userId, a.title title, a.content content, a.meta_title metaTitle, a.meta_desc metaDesc, DATE_FORMAT(a.date, \'%d/%m/%Y à %Hh%imin%ss\') AS date
        FROM user u
        INNER JOIN article a
        ON p.user_id = u.id
        WHERE p.id = :id');
        $q->execute(array('id' => $articleId));
        $data = $q->fetch();

        $article = new article($data);
        $q->closeCursor();

        return $article;
    }

    public function getListArticle($start, $articlesByPage, $whereUser)
    {
        $query = 'SELECT u.pseudo userPseudo, a.id id, a.user_id userId, a.title title, a.content content, a.meta_title metaTitle, a.meta_desc metaDesc, DATE_FORMAT(a.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN article a
            ON a.user_id = u.id
        ';
        $where = '';
        // Filter by user if $whereUser == true
        if ($whereUser > 0) {
            $where = 'WHERE p.user_id = :user_id ';
        }

        $query .= $where;
        $query .= 'ORDER BY p.date DESC
        LIMIT :start, :articles_by_page';

        $q = $this->db()->prepare($query);
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':articles_by_page', $articlesByPage, $this->db()::PARAM_INT);
        if ($whereUser > 0) {
            $q->bindValue(':user_id', $whereUser, $this->db()::PARAM_STR);
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

    public function count($userId)
    {
        $query = 'SELECT COUNT(id) FROM article';
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
        return $articleCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM article WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }
}
