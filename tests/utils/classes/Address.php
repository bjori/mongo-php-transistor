<?php
class Address implements BSON\Persistable {
    use MongoDB\Transistor;

    protected $streetAddress;
    protected $city;
    protected $postalCode;

    function __construct($streetAddress, $city, $postalCode) {
        $this->streetAddress = $streetAddress;
        $this->city          = $city;
        $this->postalCode    = $postalCode;

    }

    function getStreetAddress()  {
        return $this->streetAddress;
    }
    function __debugInfo() {
        $props = get_object_vars($this);

        unset($props["__original"]);

        return $props;
    }
}

