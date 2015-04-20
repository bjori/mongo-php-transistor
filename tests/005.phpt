--TEST--
MongoDB\Transistor #005 -- Remove element
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
var_dump($person);

$person->removeAddress($address);
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
    object(Address)#11 (5) {
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
      object(BSON\UTCDatetime)#10 (0) {
      }
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
  array(0) {
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
