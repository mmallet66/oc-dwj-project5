<?php

namespace Occazou\Src\Model;

require_once 'Model.php';

/**
 * Class UserDAO
 */
class CityModel extends Model
{
    /**
     * @return void
     */
    public function __construct()
    {
        $this->dbConnect();
    }

    public function cityExists(string $zipCode, string $name)
    {
        $req = $this->db->prepare('SELECT city_id FROM cities WHERE zip_code=:zipCode && name=:name');
        $req->execute([ ':zipCode'=>$zipCode, ':name'=>$name ]);
        return $req->rowCount();
    }

    public function add(object $city)
    {
        $req = $this->db->prepare('INSERT INTO cities(name, zip_code, region_code) VALUES(?, ?, ?)');
        return $req->execute([
            $city->getName(),
            $city->getZipCode(),
            $city->getRegion()->getCode()
        ]);
    }

    public function getCity(string $zipCode, string $name)
    {
        $req = $this->db->prepare('SELECT city_id AS id, cities.name, zip_code AS zipCode, region_code, regions.name AS region_name, regions.region_id  FROM cities JOIN regions ON regions.code = cities.region_code WHERE zip_code=:zipCode && cities.name=:name');
        $req->execute([ ':zipCode'=>$zipCode, ':name'=>$name ]);
        return $req->fetch();
    }

    public function getCityId(object $city)
    {
        if(!$this->cityExists($city->getZipCode(), $city->getName())):
            $this->add($city);
            $this->getCityId($city);
        else:
            return $this->getCity($city->getZipCode(), $city->getName())['id'];
        endif;
    }
}