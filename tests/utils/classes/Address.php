<?php
class Address implements MongoDB\BSON\Persistable {
    use MongoDB\Transistor;

    protected $_id;
    protected $streetAddress;
    protected $city;
    protected $postalCode;

    function __construct($streetAddress, $city, $postalCode) {
        $this->streetAddress = $streetAddress;
        $this->city          = $city;
        $this->postalCode    = $postalCode;

        /* Pregenerate our ObjectID */
        $this->_id     = new MongoDB\BSON\ObjectID();
    }

    function getStreetAddress()  {
        return $this->streetAddress;
    }
    function __debugInfo() {
        $props = get_object_vars($this);

        unset($props["__original"]);
        unset($props["__pclass"]);

        return $props;
    }

    function getId() {
        return $this->_id;
    }
}
