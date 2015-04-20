--TEST--
MongoDB\Transistor #006 -- Add element to array, remove another
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
$person->addAddress($address2);
$person->removeAddress($address);

var_dump($person);

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
      string(14) "Dynekilgata 15"
      ["city"]=>
      string(%d) "Oslo"
      ["postalCode"]=>
      string(%d) "0569"
    }
  }
  ["_lastModified"]=>
  NULL
  ["_created"]=>
  object(BSON\UTCDatetime)#%d (%d) {
  }
  ["scratch"]=>
  array(%d) {
  }
}
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
      string(14) "Dynekilgata 15"
      ["city"]=>
      string(%d) "Oslo"
      ["postalCode"]=>
      string(%d) "0569"
      ["_created"]=>
      object(BSON\UTCDatetime)#%d (%d) {
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
