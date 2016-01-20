<?php


function insert(MongoDB\BSON\Persistable $object) {
    global $_manager;

    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->insert($object);
        $_manager->executeBulkWrite(NS, $bulk);
    } catch(Exception $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }
}

function update(array $array = array(), MongoDB\BSON\Persistable $object) {
    global $_manager;

    try {
        $bulk = new MongoDB\Driver\BulkWrite;
        $bulk->update($array, $object);
        $_manager->executeBulkWrite(NS, $bulk);
    } catch(Exception $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }

    return findOne($array);
}

function findOne(array $array = array()) {
    global $_manager;


    $result = $_manager->executeQuery(NS, new MongoDB\Driver\Query($array));

    $objects = $result->toArray();
    if ($objects) {
        return $objects[0];
    }
    $readable = var_export($array, true);
    throw new UnderflowException("No documents matched: $readable");
}

function isDatetimeSame(DateTime $dt, DateTime $dt2) {
    /* The created timestamp is 'now' */
    $diff = $dt->diff($dt2)->format("%s");
    if ($dt == $dt2) {
        echo "OK -- no bump\n";
        /* We can be really unlucky and the second bumped */
    } else if ($diff < 3) {
        printf("OK -- off by %s second :)\n", $diff);
    } else {
        echo "FAILED\n";
        var_dump($dt->diff($dt2));
    }
}
