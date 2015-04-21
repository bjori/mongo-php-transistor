--TEST--
MongoDB\Transistor #009 -- _lastModified is automatically generated & updated
--INI--
date.timezone=America/Los_Angeles
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
try {
    $dt = $person->getLastModifiedDateTime();
    echo "Failed, a _lastModified timestamp shouldn't have created\n";
} catch(OutOfBoundsException $e) {
    echo $e->getMessage(), "\n";
}

$person->setName("Dr. " . $person->getName());
$person = update(array("_id" => $person->getId()), $person);

$dt = $person->getLastModifiedDateTime();
$curr = new DateTime("now");
isDatetimeSame($dt, $curr);


$address2 = new Address("Dynekilgata 15", "Oslo", "0569");
$address3 = new Address("555 University Ave", "Palo Alto", 94301);
$person->addAddress($address2);
$person->addAddress($address3);

sleep(1);
$person = update(array("username" => "bjori"), $person);
isDatetimeSame($person->getLastModifiedDateTime(), $curr);

?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
No updates registered yet
OK -- %s
OK -- off by %d second :)
===DONE===
