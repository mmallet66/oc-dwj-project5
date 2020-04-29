<?php

namespace Occazou\Src\Model;

/**
 * Class user
 * 
 * Allows you to create a user object
 */
class User
{
// PROPERTIES
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $creationDate;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $address;

    /**
     * @var object
     */
    public $city;

// METHODS
    /**
     * Hydratation method
     * 
     * For each key in an array, it call the setter (if it exists) method for assigned a value to each property.
     * 
     * @param array $data
     */
    public function hydrate($data) {
        
        $cityData = [];
        foreach ($data as $key => $value):

            if(preg_match('/^city_([a-zA-Z_]*)$/', $key)):
                $key = str_replace('city_', '', $key);
                $cityData[$key] = $value;
            else:
                $method = "set" . ucfirst($key);

                if(method_exists($this, $method)):
                    $this->$method($value);
                endif;
            endif;

        endforeach;
        (!empty($cityData))&& $this->setCity($cityData);
    }

// SETTERS
    /**
     * @param int Value assigned to $id property
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @param string Value assigned to $username property
     */
    public function setUsername($username)
    {
        $this->username = (is_string($username))? $username : null;
    }
    
    /**
     * @param string Value assigned to $password property
     */
    public function setPassword($password)
    {
        $regExp         = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/';
        $this->password = (isset($password) && preg_match($regExp, $password))? $password : null;
    }

    /**
     * @param string Value assigned to $creationDate property
     */
    private function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @param string Value assigned to $gender property
     */
    public function setGender($gender=null)
    {
        $this->gender = ($gender === "male" || $gender === "female")? $gender : null;
    }

    /**
     * @param string Value assigned to $firstname property
     */
    public function setFirstname($firstname=null)
    {
        $this->firstname = (is_string($firstname))? $firstname : null;
    }

    /**
     * @param string Value assigned to $name property
     */
    public function setName($name=null)
    {
        $this->name = (is_string($name))? $name : null;
    }

    /**
     * @param string Value assigned to $email property
     */
    public function setEmail($email=null)
    {
        $regExp = '/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/';

        $this->email = (is_string($email) && preg_match($regExp, $email))? $email : null;
    }

    /**
     * @param int Value assigned to $phone property
     */
    public function setPhone($phone)
    {
        $phone = (int) $phone;
        $regExp = '/^[0-9]{9}$/';

        $this->phone = preg_match($regExp, $phone)? $phone : null;
    }

    /**
     * @param string Value assigned to $address property
     */
    public function setAddress($address=null)
    {
        $this->address = (is_string($address))? str_replace('_', ' ', $address) : null;
    }

    /**
     * Set the value of city
     *
     * @param array
     */ 
    public function setCity($cityData)
    {
        if(is_array($cityData)):
            $this->city = new City();
            $this->city->hydrate($cityData);
        endif;
    }

// GETTERS
    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getCreationDate() { return $this->creationDate; }
    public function getGender() { return $this->gender; }
    public function getFirstname() { return $this->firstname; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getPhone() { return $this->phone; }
    public function getAddress() { return $this->address; }
    public function getCity() { return $this->city; }

}