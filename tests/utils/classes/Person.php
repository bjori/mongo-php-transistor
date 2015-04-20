<?php
class Person implements BSON\Persistable {
    use MongoDB\Transistor;

    protected $_id;
    protected $username;
    protected $email;
    protected $name;
    protected $addresses = array();
    protected $_lastModified;
    protected $_created;
    protected $scratch = array();

    function __construct($username, $email, $name) {
        $this->username = $username;
        $this->email    = $email;
        $this->setName($name);

        /* Pregenerate our ObjectID */
        $this->_id     = new BSON\ObjectID();
    }

    function getId() {
        return $this->_id;
    }
    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getName() {
        return $this->name;
    }

    function getAddresses() {
        return $this->addresses;
    }

    function addAddress(Address $address) {
        $this->addresses[] = $address;
    }

    function removeAddress(Address $address) {
        foreach($this->getAddresses() as $k => $curr) {
            if ($curr->getId() == $address->getid()) {
                unset($this->addresses[$k]);

                /* We need to reindex the PHP array so it starts from 0 again */
                $this->addresses = array_values($this->addresses);
                return true;
            }
        }

        throw new UnderflowException("No Address found: " . $address->getAddresses()->getStreetAddress());
    }
    function setName($name) {
        return $this->name = $name;
    }

    function __debugInfo() {
        $props = get_object_vars($this);

        unset($props["__original"]);

        return $props;
    }

    function setScratch($scratch) {
        $this->scratch = $scratch;
    }
}

