<?php

namespace occazou\src\model;

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
     * @var int
     */
    private $pictureId;

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
     * Set the value of authorId
     *
     * @param int $authorId
     */ 
    private function setAuthorId($authorId)
    {
        $this->authorId = (int) $authorId;
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
     * @param float $price
     */ 
    public function setPrice($price)
    {
        $this->price = (float) $price;
    }

    /**
     * Set the value of pictureId
     *
     * @param int $pictureId
     */ 
    public function setPictureId($pictureId)
    {
        $this->pictureId = (int) $pictureId;
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
    public function getTitle(){return $this->title;}
    public function getText(){return $this->text;}
    public function getPrice(){return $this->price;}
    public function getPictureId(){return $this->pictureId;}
    public function getCreationDate(){return $this->creationDate;}
}
