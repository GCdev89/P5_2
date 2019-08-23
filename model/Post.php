<?php
namespace Gaetan\P5\Model;

class Post
{
    /**
    *@var int $_id
    *@var string $_user_id
    *@var string $_user_pseudo
    *@var string $_title
    *@var string $_content
    *@var string $_meta_title
    *@var string $_meta_desc
    *@var int $_date
    */

    private $_id;
    private $_user_id;
    private $_user_pseudo;
    private $_title;
    private $_content;
    private $_meta_title;
    private $_meta_desc;
    private $_date;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters

    public function id()
    {
        return $this->_id;
    }

    public function userId()
    {
        return $this->_user_id;
    }

    public function userPseudo()
    {
        return $this->_user_pseudo;
    }

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function metaTitle()
    {
        return $this->_meta_title;
    }

    public function metaDesc()
    {
        return $this->_meta_desc;
    }

    public function date()
    {
        return $this->_date;
    }

    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setUserId($userId)
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->_user_id = $userId;
        }
    }

    public function setUserPseudo($userPseudo)
    {
        if(is_string($userPseudo))
        {
            $this->_user_pseudo = $userPseudo;
        }
    }

    public function setTitle($title)
    {
        if(is_string($title))
        {
            $this->_title = $title;
        }
    }

    public function setContent($content)
    {
        if(is_string($content))
        {
            $this->_content = $content;
        }
    }

    public function setMetaTitle($metaTitle)
    {
        if(is_string($metaTitle))
        {
            $this->_meta_title = $metaTitle;
        }
    }

    public function setMetaDesc($metaDesc)
    {
        if(is_string($metaDesc))
        {
            $this->_meta_desc = $metaDesc;
        }
    }

    public function setDate($date)
    {
        if(is_string($date))
        {
            $this->_date = $date;
        }
    }
}
