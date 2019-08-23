<?php
namespace Gaetan\P5\Model;

class Article
{
    /**
    *@var int $_id
    *@var string $_user_id
    *@var string $_user_pseudo
    *@var string $_title
    *@var string $_content
    *@var string $_description
    *@var string $_parent either 'dad', 'mom' or 'both'
    *@var string $_tag_1
    *@var string $_tag_2
    *@var string $_tag_3
    *@var string $_meta_title
    *@var string $_meta_desc
    *@var int $_date
    */

    private $_id;
    private $_user_id;
    private $_user_pseudo;
    private $_title;
    private $_content;
    private $_description;
    private $_parent;
    private $_tag_1;
    private $_tag_2 ;
    private $_tag_3;
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

    public function description()
    {
        return $this->_description;
    }

    public function parent()
    {
        return $this->_parent;
    }

    public function tag_1()
    {
        return $this->_tag_1;
    }

    public function tag_2()
    {
        return $this->_tag_2;
    }

    public function tag_3()
    {
        return $this->_tag_3;
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

    public function setDescription($description)
    {
        if(is_string($description))
        {
            $this->_description = $description;
        }
    }

    public function setParent($parent)
    {
        if(is_string($parent))
        {
            $this->_parent = $parent;
        }
    }

    public function setTag_1($tag_1)
    {
        if(is_string($tag_1))
        {
            $this->_tag_1 = $tag_1;
        }
    }

    public function setTag_2($tag_2)
    {
        if(is_string($tag_2))
        {
            $this->_tag_2 = $tag_2;
        }
    }

    public function setTag_1($tag_3)
    {
        if(is_string($tag_3))
        {
            $this->_tag_3 = $tag_3;
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
