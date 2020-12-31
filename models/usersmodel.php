<?php

class UsersModel extends Model
{
    private $_name;
    private $_password;
    private $_email;
    private $_isAdmin;

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->_isAdmin = $isAdmin;
    }

    public function store()
    {
        $sql = "INSERT INTO users
        (name, password, email, is_admin)
        VALUES
        (?, ?, ?, ?)";

        $data = array(
            $this->_name,
            $this->_password,
            $this->_email,
            $this->_isAdmin
        );

        $sth = $this->_db->prepare($sql);
        return $sth->execute($data);
    }
    
    public function checkUser()
    {
        $sql = "SELECT COUNT(*) 
        FROM users
        WHERE email = ?";

        $data = $this->_email;
        $sth = $this->_db->prepare($sql);
        
        return $sth->execute(array($data));
    }

    public function selectUser()
    {
        $sql = "SELECT * 
        FROM users
        WHERE email = ? AND password = ?";

        $data = [
            $this->_email,
            $this->_password
        ];
        $this->_setSql($sql);
        $user = $this->getRow($data);

        if (empty($user))
        {
            return false;
        }

        return $user;
    }
}