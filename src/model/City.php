<?php

namespace Occazou\Src\Model;

class City
{
//PROPERTIES
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $zipCode;
    /**
     * @var string
     */
    private $region;

// METHODS
    /**
     * Hydratation method
     * 
     * For each key in an array, it call the setter (if it exists) method for assigned a value to each property.
     * 
     * @param array $data
     */
    public function hydrate($data) {
        $regionData = [];
        foreach ($data as $key => $value):

            if(preg_match('/^region_([a-zA-Z_]*)$/', $key)):
                $key = str_replace('city_', '', $key);
                $regionData[$key] = $value;
            else:
                $method = "set" . ucfirst($key);

                if(method_exists($this, $method)):
                    $this->$method($value);
                endif;
            endif;

        endforeach;
        (!empty($regionData))&& $this->setRegion($regionData);
    }

//SETTERS
    /**
     * Set the value of id
     *
     * @return self
     */ 
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set the value of name
     *
     * @return self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of zipCode
     *
     * @return self
     */ 
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Set the value of region
     *
     * @param array
     */ 
    public function setRegion(array $regionData)
    {
        $this->region = new Region();
        $this->region->hydrate($regionData);
    }

// GETTERS
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of zipCode
     */ 
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Get the value of region
     */ 
    public function getRegion()
    {
        return $this->region;
    }
}