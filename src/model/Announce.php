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
    private $author;

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
    public function hydrate($data)
    {
        $authorData = [];
        foreach ($data as $key => $value):

            if(preg_match('/^author_([a-zA-Z_]*)$/', $key)):
                $key = str_replace('author_', '', $key);
                $authorData[$key] = $value;
            else:
                $method = "set" . ucfirst($key);

                if(method_exists($this, $method)):
                    $this->$method($value);
                endif;
            endif;

        endforeach;
        (!empty($authorData))&& $this->setAuthor($authorData);
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
     * Set the value of author
     *
     * @param int $author
     */ 
    private function setAuthor($authorData)
    {
        if(is_array($authorData)):
            $this->author = new User;
            $this->author->hydrate($authorData);
        endif;
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
    public function getAuthor(){return $this->author;}
    public function getTitle(){return $this->title;}
    public function getText(){return $this->text;}
    public function getPrice(){return $this->price;}
    public function getPictureName(){return $this->pictureName;}
    public function getCreationDate(){return $this->creationDate;}
}
