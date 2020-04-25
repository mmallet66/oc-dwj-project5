<?php

namespace Occazou\Src\Model;

class City
{
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
    private $regionCode;
    /**
     * @var string
     */
    private $regionName;

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

            if(method_exists($this, $method)):
                $this->$method($value);
            endif;
        }
    }

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
     * Set the value of regionCode
     *
     * @return self
     */ 
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    /**
     * Set the value of regionName
     *
     * @return self
     */ 
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;

        return $this;
    }

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
     * Get the value of regionCode
     */ 
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Get the value of regionName
     */ 
    public function getRegionName()
    {
        return $this->regionName;
    }
}