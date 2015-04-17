--TEST--
MongoDB\Transistor #003 -- Update existing field
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

$person->setName("Hannes <bjori> Magnnusson");

$person = update(array("username" => "bjori"), $person);
var_dump($person);

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
object(Person)#%d5 (8) {
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
  string(25) "Hannes <bjori> Magnnusson"
  ["addresses"]=>
  array(1) {
    [0]=>
    object(Address)#%d2 (4) {
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
  object(BSON\UTCDatetime)#%d4 (0) {
  }
  ["_created"]=>
  object(BSON\UTCDatetime)#%d3 (0) {
  }
  ["scratch"]=>
  array(0) {
  }
}
===DONE===
