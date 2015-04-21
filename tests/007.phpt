--TEST--
MongoDB\Transistor #007 -- Add multiple elements to array
--SKIPIF--
<?php require __DIR__ . "/" . "./utils/basic-skipif.inc"; CLEANUP(STANDALONE) ?>
--FILE--
<?php
require_once __DIR__ . "/" . "./utils/basic.inc";


$person = new Person("bjori", "bjori@php.net", "Hannes Magnusson");
$address = new Address("Manabraut 4", "Kopavogur", 200);
$person->addAddress($address);

insert($person);
$person = findOne(array("username" => "bjori"));


$address2 = new Address("Dynekilgata 15", "Oslo", "0569");
$address3 = new Address("555 University Ave", "Palo Alto", 94301);
$person->addAddress($address2);
$person->addAddress($address3);

$person = update(array("username" => "bjori"), $person);
var_dump($person);

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(Person)#%d (%d) {
  ["_id"]=>
  object(BSON\ObjectID)#%d (%d) {
    ["oid"]=>
    string(24) "%s"
  }
  ["username"]=>
  string(%d) "bjori"
  ["email"]=>
  string(13) "bjori@php.net"
  ["name"]=>
  string(16) "Hannes Magnusson"
  ["addresses"]=>
  array(%d) {
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
    [1]=>
    object(Address)#%d (%d) {
      ["_id"]=>
      object(BSON\ObjectID)#%d (%d) {
        ["oid"]=>
        string(24) "%s"
      }
      ["streetAddress"]=>
      string(14) "Dynekilgata 15"
      ["city"]=>
      string(%d) "Oslo"
      ["postalCode"]=>
      string(%d) "0569"
      ["_created"]=>
      object(BSON\UTCDatetime)#%d (%d) {
      }
    }
    [2]=>
    object(Address)#%d (%d) {
      ["_id"]=>
      object(BSON\ObjectID)#%d (%d) {
        ["oid"]=>
        string(24) "%s"
      }
      ["streetAddress"]=>
      string(18) "555 University Ave"
      ["city"]=>
      string(9) "Palo Alto"
      ["postalCode"]=>
      int(94301)
      ["_created"]=>
      object(BSON\UTCDatetime)#%d (0) {
      }
    }
  }
  ["_lastModified"]=>
  object(BSON\UTCDatetime)#%d (%d) {
  }
  ["_created"]=>
  object(BSON\UTCDatetime)#%d (%d) {
  }
  ["scratch"]=>
  array(%d) {
  }
}
===DONE===
