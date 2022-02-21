<?php

namespace Api\Infra;

use Api\Domain\User\UserRepo;
use Api\Domain\User\User;

require_once("config.php");

class UserRepoPdo implements UserRepo 
{
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = new \PDO(DBDRIVE.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPASS);
    }

    public function create(User $user):bool
    {
        $fields = array('name', 'address', 'city', 'state');
        $user = $user->whoIs();
        
        $sql = 'INSERT INTO users VALUES (NULL, :name, :address, :city, :state);';

        $stmt = $this->conn->prepare($sql);
        foreach ($fields as $field) {
            foreach ($user as $key => $value) {
                if($field == $key)
                    $stmt->bindValue($field, $value);
            }
        }
       
        $stmt->execute();

        if($stmt->rowCount() > 0)
            return true;
    
        return false;
    }

    public function read(int $id):mixed
    {
        $sql = 'SELECT u.name, u.address, c.city, s.state FROM users AS u INNER JOIN cities AS c ON c.id=u.city INNER JOIN states AS s ON c.idState=s.id WHERE u.id=:id';
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function update(int $id, User $user):bool
    {
        $user = $user->whoIs();

        $sql = 'UPDATE users SET';
        foreach ($user as $key => $value)
        {
            if($value != '' && $value != 0)
            {
                if(is_numeric($value))
                    $sql .= ' '.$key.'='.$value.',';
                else
                    $sql .= ' '.$key.'="'.$value.'",';

            }
        }   
        $sql = substr($sql, 0, -1);
        $sql .= ' WHERE id='.$id;
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        if($stmt->rowCount() > 0)
            return true;
    
        return false;
    }

    public function delete(int $id):bool
    {
        $sql = 'DELETE FROM teste.users WHERE id=:id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0)
            return true;
        
        return false;
    }
}
