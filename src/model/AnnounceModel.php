<?php

namespace Occazou\Src\Model;

require_once 'Model.php';

/**
 * Class AnnounceModel
 */
class AnnounceModel extends Model
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->dbConnect();
    }

    /**
     * Register a new announce in the database
     * 
     * @param object $announce
     * 
     * @return int or false
     */
    public function addAnnounce(object $announce)
    {
        $req = $this->db->prepare('INSERT INTO announces(author_id, title, text, price, picture_name) VALUES(:authorId, :title, :text, :price, :pictureName)');

        return $req->execute(array(
            ':authorId'=>$announce->getAuthor()->getId(),
            ':title'=>$announce->getTitle(),
            ':text'=>$announce->getText(),
            ':price'=>$announce->getPrice(),
            ':pictureName'=>$announce->getPictureName()
        ));
    }

    /**
     * Retrieves an announce's datas from the database, and returns an array of datas
     * 
     * @param int $announceId
     * 
     * @return array
     */
    public function getAnnounce($announceId)
    {
        $req = $this->db->prepare('SELECT announce_id AS id, author_id, title, text, price, picture_name AS pictureName, DATE_FORMAT(announces.creation_date, "le %d/%m/%Y à %Hh%i") AS creationDate, users.username AS author_username, users.creation_date AS author_creation_date, users.gender AS author_gender, users.firstname AS author_firstname, users.name AS author_name, users.email AS author_email, users.phone AS author_phone, users.address AS author_address, cities.city_id AS author_city_id, cities.name AS author_city_name, cities.zip_code AS author_city_zip_code, regions.region_id AS author_region_region_id, regions.code AS author_region_code, regions.name AS author_region_name FROM announces LEFT JOIN users ON announces.author_id = users.user_id LEFT JOIN cities ON users.city_id = cities.city_id LEFT JOIN regions ON cities.region_code = regions.code WHERE announce_id=?');
        $data = $req->execute([$announceId]);
        if($data = $req->fetch()):
            return $data;
        else:
            throw new \Exception("Cette annonce n'existe pas");
        endif;
    }

    public function getAnnouncesByCity($city)
    {
        // $req = $this->db->prepare('SELECT announces.announce_id AS id, author_id AS authorId, users.username AS authorUsername, title, text, price, users.city AS city, announces.picture_id AS pictureId, pictures.name AS picturePath, announces.creation_date AS creationDate FROM announces LEFT JOIN users ON announces.author_id = users.user_id LEFT Join pictures ON announces.picture_id = pictures.picture_id WHERE users.city=?');

        // $announceData = ($req->execute([$city]))? $req->fetch() : false;

        // return $announceData;
    }

    public function getUserAnnounces($userId)
    {
        $req = $this->db->prepare('SELECT announce_id AS id, author_id, title, text, price, picture_name AS pictureName, DATE_FORMAT(creation_date, "%d/%m/%Y") AS creationDate FROM announces WHERE author_id=?');
        return ($req->execute([$userId]))? $req->fetchAll() : null;
    }

    public function deleteAnnounce($announceId)
    {
        $req = $this->db->prepare('DELETE FROM announces WHERE announce_id=?');
        $data = $req->execute([$announceId]);
        if($data):
            return $data;
        else:
            throw new \Exception("Cette annonce n'existe pas");
        endif;
    }
}