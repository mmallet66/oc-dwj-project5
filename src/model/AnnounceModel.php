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
        // $req = $this->db->prepare('SELECT announces.announce_id AS id, author_id AS authorId, users.username AS authorUsername, title, text, price, users.city AS city, announces.picture_id AS pictureId, pictures.name AS picturePath, announces.creation_date AS creationDate FROM announces LEFT JOIN users ON announces.author_id = users.user_id LEFT Join pictures ON announces.picture_id = pictures.picture_id WHERE announces.announce_id=?');

        // $announceData = ($req->execute([$announceId]))? $req->fetch() : false;

        // return $announceData;
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
}