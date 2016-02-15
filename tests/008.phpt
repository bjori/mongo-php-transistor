--TEST--
MongoDB\Transistor #008 -- _created is automatically generated
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

try {
    $person->getCreatedDateTime();
    echo "Failed, a _created timestamp shouldn't have created\n";
} catch(OutOfBoundsException $e) {
    echo $e->getMessage(), "\n";
}

insert($person);
sleep(1);
$personFromDb = findOne(array("username" => "bjori"));
$dtFromDb = $personFromDb->getCreatedDateTime();
$dt = $person->getCreatedDateTime();
$curr = new DateTime("now");

isDatetimeSame($dtFromDb, $curr);
isDatetimeSame($dtFromDb, $dt);


?>
===DONE===
<?php exit(0); ?>
--EXPECTF--
No creation time registered yet
OK -- off by %d second :)
OK -- no bump
===DONE===
