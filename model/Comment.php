<?php
namespace Gaetan\P5_2\Model;

class Comment
{
    /**
    *@var int $_id
    *@var int $_user_id
    *@var int $_content_id
    *@var string $_user_pseudo
    *@var string $_type define either article or post comment
    *@var string $_content
    *@var int $_report If $_report == 1, the comment is reported
    *@var int $_date
    */

    private $_id;
    private $_user_id;
    private $_content_id;
    private $_user_pseudo;
    private $_type;
    private $_content;
    private $_report;
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

    public function contentId()
    {
        return $this->_content_id;
    }

    public function userPseudo()
    {
        return $this->_user_pseudo;
    }

    public function type()
    {
        return $this->_type;
    }

    public function content()
    {
        return $this->_content;
    }

    public function report()
    {
        return $this->_report;
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

    public function setContentId($contentId)
    {
        $contentId = (int) $contentId;
        if ($contentId > 0) {
            $this->_content_id = $contentId;
        }
    }

    public function setUserPseudo($userPseudo)
    {
        if(is_string($userPseudo))
        {
            $this->_user_pseudo = $userPseudo;
        }
    }

    public function setType($type)
    {
        if(is_string($type))
        {
            $this->_type = $type;
        }
    }

    public function setContent($content)
    {
        if(is_string($content))
        {
            $this->_content = $content;
        }
    }

    public function setReport($report)
    {
        $report = (int) $report;
        if ($report >= 0) {
            $this->_report = $report;
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
