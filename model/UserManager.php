<?php
namespace Gaetan\P5_2\Model;

require_once('../model/Manager.php');
require('../model/User.php');

class UserManager extends Manager
{
    public function add(User $user)
    {
        $q = $this->db()->prepare('INSERT INTO user(role, pseudo, password, mail, date) VALUES(:role, :pseudo, :password, :mail, NOW())');
        $affectedLines= $q->execute(array(
            'role' => $user->role(),
            'pseudo' => $user->pseudo(),
            'mail' => $user->mail(),
            'password' => $user->password()
        ));
        return $affectedLines;
    }

    public function getUser($info)
    {
        if (is_int($info))
        {
            $q = $this->db()->prepare('SELECT id, role, pseudo, password, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin\') AS date FROM user WHERE id = :id');
            $q->execute(array('id' => $info));
            $data = $q->fetch();

            $user = new User($data);
            $q->closeCursor();

            return $user;
        }
        else {
            $q = $this->db()->prepare('SELECT id, role, pseudo, password, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin\') AS date FROM user WHERE pseudo = :pseudo');
            $q->execute(array('pseudo' => $info));
            $data = $q->fetch();

            $user = new User($data);
            $q->closeCursor();

            return $user;
        }

    }

    public function getListUsers($start, $usersByPage)
    {
        $users = [];

        $q = $this->db()->prepare('SELECT id, role, pseudo, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin\') AS date FROM user ORDER BY pseudo ASC LIMIT :start, :users_by_page');
        $q->bindValue(':start', $start, $this->db()::PARAM_INT);
        $q->bindValue(':users_by_page', $usersByPage, $this->db()::PARAM_INT);
        $q->execute();
        while($data = $q->fetch())
        {
            $users[] = new User($data);
        }
        $q->closeCursor();

        return $users;
    }

    public function updateMail(User $user)
    {
        $q = $this->db()->prepare('UPDATE user SET mail = :mail WHERE id = :id');
        $affectedLines = $q->execute(array(
            'mail' => $user->mail(),
            'id' => $user->id()
        ));
        return $affectedLines;
    }

    public function updatePassword(User $user)
    {
        $q = $this->db()->prepare('UPDATE user SET password = :password WHERE id = :id');
        $affectedLines = $q->execute(array(
            'password' => $user->password(),
            'id' => $user->id()
        ));
        return $affectedLines;
    }

    public function updateRole(User $user)
    {
        $q = $this->db()->prepare('UPDATE user SET role = :role WHERE id = :id');
        $affectedLines = $q->execute(array(
            'role' => $user->role(),
            'id' => $user->id()
        ));
        return $affectedLines;
    }

    public function delete($userId)
    {
        $q = $this->db()->prepare('DELETE FROM user WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $userId));

        return $affectedLines;
    }

    public function count()
    {
        $q = $this->db()->query('SELECT COUNT(id) FROM user');
        return $usersCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM user WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    public function pseudoExists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM user WHERE pseudo = :pseudo');
        $q->execute(array('pseudo' => $data));
        return (bool) $q->fetchColumn();
    }

    public function mailExists($data)
    {
        $q = $this->db()->prepare('SELECT COUNT(*) FROM user WHERE mail = :mail');
        $q->execute(array('mail' => $data));
        return (bool) $q->fetchColumn();
    }
}
