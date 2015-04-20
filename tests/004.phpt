--TEST--
MongoDB\Transistor #004 -- Add element to array
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


$address = new Address("Dynekilgata 15", "Oslo", "0569");
$person->addAddress($address);

$person = update(array("username" => "bjori"), $person);
var_dump($person);

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(Person)#%d (%d) {
  ["_id"]=>
  object(BSON\ObjectID)#%d (1) {
    ["oid"]=>
    string(24) "%s"
  }
  ["username"]=>
  string(5) "bjori"
  ["email"]=>
  string(13) "bjori@php.net"
  ["name"]=>
  string(16) "Hannes Magnusson"
  ["addresses"]=>
  array(2) {
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
      string(4) "Oslo"
      ["postalCode"]=>
      string(4) "0569"
      ["_created"]=>
      object(BSON\UTCDatetime)#%d (0) {
      }
    }
  }
  ["_lastModified"]=>
  object(BSON\UTCDatetime)#%d (0) {
  }
  ["_created"]=>
  object(BSON\UTCDatetime)#%d (0) {
  }
  ["scratch"]=>
  array(0) {
  }
}
===DONE===
