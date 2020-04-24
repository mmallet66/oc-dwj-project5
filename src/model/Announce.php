<?php

namespace Occazou\Src\Model;

/**
 * Class Announce
 * 
 * Allows you to create a announce object
 */
class Announce
{
// PROPERTIES
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $authorId;

    /**
     * @var string
     */
    private $authorUsername;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $text;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $pictureName;

    /**
     * @var string
     */
    private $creationDate;

// METHODS
    /**
     * Hydratation method
     * 
     * For each key in an array, it call the setter (if it exists) method for assigned a value to each property.
     * 
     * @param array $data
     */
    public function hydrate($data) {
        foreach ($data as $key => $value)
        {
            $method = "set" . ucfirst($key);

            if(method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

// SETTERS
    /**
     * Set the value of id
     *
     * @param int $id
     */ 
    private function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Set the value of authoId
     *
     * @param int $authorId
     */ 
    private function setAuthorId($authorId)
    {
        $this->authorId = (int) $authorId;
    }

    /**
     * Set the value of authorUsername
     *
     * @param string $authorUsername
     */ 
    private function setAuthorUsername($authorUsername)
    {
        $this->authorUsername = (is_string($authorUsername))? $authorUsername : null;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     */ 
    public function setTitle($title)
    {
        $this->title = (is_string($title))? $title : null;
    }

    /**
     * Set the value of text
     *
     * @param string $text
     */ 
    public function setText($text)
    {
        $this->text = (is_string($text))? $text : null;
    }

    /**
     * Set the value of price
     *
     * @param int $price
     */ 
    public function setPrice($price)
    {
        $this->price = (int) $price;
    }

    /**
     * Set the value of city
     *
     * @param string $city
     */ 
    public function setCity($city)
    {
        $this->city = (is_string($city))? $city : null;
    }

    /**
     * Set the value of pictureName
     *
     * @param string $pictureName
     */ 
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;
    }

    /**
     * Set the value of creationDate
     *
     * @param string $creationDate
     */ 
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

// GETTERS
    public function getId(){return $this->id;}
    public function getAuthorId(){return $this->authorId;}
    public function getAuthorUsername(){return $this->authorUsername;}
    public function getTitle(){return $this->title;}
    public function getText(){return $this->text;}
    public function getPrice(){return $this->price;}
    public function getCity(){return $this->city;}
    public function getPictureName(){return $this->pictureName;}
    public function getCreationDate(){return $this->creationDate;}
}
