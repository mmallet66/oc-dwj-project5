<?php

namespace Occazou\Src\Model;

class Region
{
// PROPERTIES
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
    private $code;

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
            $key = str_replace('region_', '', $key);
            $method = "set" . ucfirst($key);

            if(method_exists($this, $method)):
                $this->$method($value);
            endif;
        }
    }

// SETTERS
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
     * Set the value of code
     *
     * @return self
     */ 
    public function setcode($code)
    {
        $this->code = $code;

        return $this;
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
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }
}