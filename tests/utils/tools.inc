<?php


function insert(BSON\Persistable $object) {
    global $_manager;

    try {
        $_manager->executeInsert(NS, $object);
    } catch(Exception $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }
}

function update(array $array = array(), BSON\Persistable $object) {
    global $_manager;

    try {
        $_manager->executeUpdate(NS, $array, $object);
    } catch(Exception $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }

    return findOne($array);
}

function findOne(array $array = array()) {
    global $_manager;


    $result = $_manager->executeQuery(NS, new MongoDB\Driver\Query($array));
    $result->setTypeMap(array("document" => "array"));

    $objects = $result->toArray();
    if ($objects) {
        return $objects[0];
    }
    $readable = var_export($array, true);
    throw new UnderflowException("No documents matched: $readable");
}

