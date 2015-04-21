# mongo-php-transistor

[![Build Status](https://api.travis-ci.org/bjori/mongo-php-transistor.png?branch=master)](https://travis-ci.org/bjori/mongo-php-transistor)

The new [PHP Driver for MongoDB](10gen-labs/mongo-php-driver-prototype) provides a
[BSON\Persistable](http://php.net/BSON\\Persistable) interface which declares
two methods to be called when storing the object, and the other when re-constructing it.

This `transistor` trait adds example implementation of the two methods and introduces
lightweight change tracking. This allows the object to be seamlessly updated as well.



## Example classes

```php
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
}

class Address implements BSON\Persistable {
    use MongoDB\Transistor;
    protected $_id;
    protected $streetAddress;
    protected $city;
    protected $postalCode;
}
?>
```
See [Person.php](tests/utils/classes/Person.php) and [Address.php](tests/utils/classes/Address.php) for
the full implementation of these example classes -- although this is really it. No annotations or anything.
`implements BSON\Persistable` and `use MongoDB\Transistor` is the magic.

## Simple usage

```php
<?php
/* Construct a new person */
$person = new Person("bjori", "bjori@php.net", "Hannes Magnusson");

/* Insert it */
insert($person);

/* Find a person based on its username */
$person = findOne(array("username" => "bjori"));

/* Get an instance of the Person object again */
var_dump($person);
?>
```

The above example will output something similar to

```
object(Person)#8 (7) {
  ["_id"]=>
  object(BSON\ObjectID)#4 (1) {
    ["oid"]=>
    string(24) "553586e2bd21b971774b7da1"
  }
  ["username"]=>
  string(5) "bjori"
  ["email"]=>
  string(13) "bjori@php.net"
  ["name"]=>
  string(16) "Hannes Magnusson"
  ["addresses"]=>
  array(0) {
  }
  ["_lastModified"]=>
  NULL
  ["_created"]=>
  object(BSON\UTCDatetime)#7 (0) {
  }
}
```

## Updating the object

```php
<?php
/* Continuing from previous example, $person is instanceof Person */
$person->setName("Dr. " . $person->getName());

/* Update the document */
update(array("username" => "bjori"), $person);

/* Retrieve it again */
$person = findOne(array("username" => "bjori"));

/* Get an instance of the Person object again */
var_dump($person);
?>
```

The above example will output something similar to

```
object(Person)#9 (7) {
  ["_id"]=>
  object(BSON\ObjectID)#4 (1) {
    ["oid"]=>
    string(24) "553586e2bd21b971774b7da1"
  }
  ["username"]=>
  string(5) "bjori"
  ["email"]=>
  string(13) "bjori@php.net"
  ["name"]=>
  string(16) "Dr. Hannes Magnusson"
  ["addresses"]=>
  array(0) {
  }
  ["_lastModified"]=>
  NULL
  ["_created"]=>
  object(BSON\UTCDatetime)#7 (0) {
  }
}
```

## Adding embedded objects

```php
<?php
/* Continuing from previous example, $person is instanceof Person */

/* Construct a new Address object */
$address = new Address("Manabraut 4", "Kopavogur", 200);
$person->addAddress($address);

/* Update the object with a new Address embedded object */
update(array("username" => "bjori"), $person);

$person = findOne(array("username" => "bjori"));
var_dump($person);
?>
```

The above example will output something similar to

```
object(Person)#10 (7) {
  ["_id"]=>
  object(BSON\ObjectID)#4 (1) {
    ["oid"]=>
    string(24) "553586e2bd21b971774b7da1"
  }
  ["username"]=>
  string(5) "bjori"
  ["email"]=>
  string(13) "bjori@php.net"
  ["name"]=>
  string(16) "Dr. Hannes Magnusson"
  ["addresses"]=>
  array(1) {
    [0]=>
    object(Address)#%d (%d) {
      ["_id"]=>
      object(BSON\ObjectID)#%d (%d) {
        ["oid"]=>
        string(24) "%s"
      }
      ["streetAddress"]=>
      string(11) "Manabraut 4"
      ["city"]=>
      string(9) "Kopavogur"
      ["postalCode"]=>
      int(200)
      ["_created"]=>
      object(BSON\UTCDatetime)#%d (0) {
      }
    }
  }
  ["_lastModified"]=>
  NULL
  ["_created"]=>
  object(BSON\UTCDatetime)#7 (0) {
  }
}
```


### Helpers

The [insert()](tests/utils/tools.inc#L4-L13), [update()](tests/utils/tools.inc#L15-L26)
and [findOne()](tests/utils/tools.inc#L28-L41) helpers in the example above don't do
anything other then wrap their respective methods on the
[MongoDB\Driver\Manager](http://php.net/MongoDB\\Driver\\Manager) and setting the
[TypeMap](http://php.net/MongoDB\\Driver\\Cursor.settypemap), and are only there to reduce error checking needed
in the examples.


## Performance

Since the actual object (un-)serialization is done by the extension itself there
is nothing for PHP to do -- the trait itself is under 200 lines of dead simple code.



I'm sure there are dragons, so use with care.
