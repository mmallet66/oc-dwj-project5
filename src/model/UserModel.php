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
        $req = $this->db->prepare('INSERT INTO users(username, password, gender, firstname, name, email, phone, address, city_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

        $affectedLine = $req->execute(array(
            $user->getUsername(),
            password_hash($user->getPassword(), PASSWORD_DEFAULT),
            $user->getGender(),
            strtolower($user->getFirstname()),
            strtolower($user->getName()),
            strtolower($user->getEmail()),
            $user->getPhone(),
            strtolower($user->getAddress()),
            $user->getCity()->getId()
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
        $req = $this->db->prepare('SELECT users.user_id AS id, users.username, users.password, users.creation_date AS creationDate, users.gender, users.firstname, users.name, users.email, users.phone, users.address, cities.city_id AS city_id, cities.name AS city_name, cities.zip_code AS city_zipCode, regions.region_id AS city_region_id, regions.code AS city_region_code, regions.name AS city_region_name FROM users INNER JOIN cities ON users.city_id = cities.city_id INNER JOIN regions ON cities.region_code = regions.code WHERE username=?');
        $userData = ($req->execute(array($username)))? $req->fetch() : false;

        return $userData;
    }

    public function getUsers()
    {
        $req = $this->db->query('SELECT users.user_id AS id, users.username, users.password, users.creation_date AS creationDate, users.gender, users.firstname, users.name, users.email, users.phone, users.address, cities.city_id AS city_id, cities.name AS city_name, cities.zip_code AS city_zipCode, regions.region_id AS city_region_id, regions.code AS city_region_code, regions.name AS city_region_name FROM users INNER JOIN cities ON users.city_id = cities.city_id INNER JOIN regions ON cities.region_code = regions.code ORDER BY creation_date ASC');
        return ($usersData = $req->fetchAll())? $usersData : false;
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
        $req = $this->db->prepare('UPDATE users SET gender=:gender, firstname=:firstname, name=:name, email=:email, phone=:phone, address=:address, city_id=:cityId WHERE user_id=:id');

        return $req->execute(array(
            ':gender'=>$user->getGender(),
            ':firstname'=>strtolower($user->getFirstname()),
            ':name'=>strtolower($user->getName()),
            ':email'=>strtolower($user->getEmail()),
            ':phone'=>$user->getPhone(),
            ':address'=>strtolower($user->getAddress()),
            ':cityId'=>$user->getCity()->getId(),
            ':id'=>$user->getId()
        ));
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

    public function deleteUser($username)
    {
        $req = $this->db->prepare('DELETE FROM users WHERE username=?');
        return $req->execute([$username]);
    }
}
