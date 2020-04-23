<?php

namespace Occazou\Src\Model;

require_once 'Model.php';

/**
 * Class UserDAO
 */
class UserModel extends Model
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->dbConnect();
    }

    /**
     * Register a new user in the database
     * 
     * @param object $user
     * 
     * @return int or false
     */
    public function addUser(object $user)
    {
        $req = $this->db->prepare('INSERT INTO users(username, password, gender, firstname, name, email, phone, address, city_name, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $affectedLine = $req->execute(array(
            $user->getUsername(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getGender(),
            $user->getFirstname(),
            $user->getName(),
            $user->getEmail(),
            $user->getPhone(),
            $user->getAddress(),
            $user->getCityName(),
            $user->getZipCode()
        ));
        
        return $affectedLine;
    }

    public function isNotFree(string $username)
    {
        $req = $this->db->prepare('SELECT username from users where username=?');
        $req->execute([$username]);
        
        return $req->rowCount();
    }

    /**
     * Retrieves a user's datas from the database, and returns an array of datas
     * 
     * @param string $username
     * 
     * @return array
     */
    public function getUser(string $username)
    {
        $req = $this->db->prepare('SELECT user_id as id, username, password, creation_date as creationDate, gender, firstname, name, email, phone, address, city_name AS cityName, zip_code AS zipCode FROM users WHERE username=?');
        $userData = ($req->execute(array($username)))? $req->fetch() : false;

        return $userData;
    }

    /**
     * Update a user's datas in the database
     * 
     * @param object $user
     * 
     * @return int or false
     */
    public function updateUser(object $user)
    {
        $req = $this->db->prepare('UPDATE users SET username=:username, gender=:gender, firstname=:firstname, name=:name, email=:email, phone=:phone, address=:address, city_name=:cityName, zip_code=:ipCode WHERE user_id=:id');

        return $req->execute(array(':username'=>$user->getUsername(), ':gender'=>$user->getGender(), ':firstname'=>$user->getFirstname(), ':name'=>$user->getName(), ':email'=>$user->getEmail(), ':phone'=>$user->getPhone(), ':address'=>$user->getAddress(), ':cityName'=>$user->getCityName(), ':zipCode'=>$user->getZipCode(), ':id'=>$user->getId()));
    }

    /**
     * Update the user's password in the database
     * 
     * @param object $user
     * 
     * @return int or false
     */
    public function updateUserPassword(object $user)
    {
        $req = $this->db->prepare('UPDATE users SET password=:password WHERE user_id=:id');

        return $req->execute(array('password'=>password_hash($user->getPassword(), PASSWORD_DEFAULT),':id'=>$user->getId()));
    }
}
