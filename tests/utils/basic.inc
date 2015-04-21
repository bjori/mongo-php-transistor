<?php

require __DIR__ . "/" . "./../../src/MongoDB/Transistor.php";
require __DIR__ . "/" . "./classes/Address.php";
require __DIR__ . "/" . "./classes/Person.php";
require __DIR__ . "/" . "./tools.inc";


function makeCollectionNameFromFilename($filename) {
    $filename = realpath($filename);
    $prefix = realpath(dirname(__FILE__) . '/..') . DIRECTORY_SEPARATOR;

    $replacements = array(
        // Strip test path prefix
        sprintf('/^%s/', preg_quote($prefix, '/')) => '',
        // Strip file extension suffix
        '/\.php$/' => '',
        // SKIPIFs add ".skip" between base name and extension
        '/\.skip$/' => '',
        // Replace special characters with underscores
        sprintf('/[%s]/', preg_quote('-$/\\', '/')) => '_',
    );

    return preg_replace(array_keys($replacements), array_values($replacements), $filename);
}

function CLEANUP($uri, $dbname = DATABASE_NAME, $collname = COLLECTION_NAME) {
    try {
        $manager = new MongoDB\Driver\Manager($uri);
        $cmd = new MongoDB\Driver\Command(array("drop" => $collname));
        $rp = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
        try {
            $manager->executeCommand($dbname, $cmd, $rp);
        } catch(Exception $e) {
            do {
                /* ns not found */
                if ($e->getCode() == 59) {
                    continue;
                }
                throw $e;
            } while (0);
        }
    } catch(Exception $e) {
        echo "skip (cleanup): '$uri';" . $e->getCode(), ": ", $e->getMessage();
        exit(1);
    }
}

function def($arr) {
    foreach($arr as $const => $value) {
        define($const, getenv("PHONGO_TEST_$const") ?: $value);
    }
}


$FILENAME = sys_get_temp_dir() . "/PHONGO-SERVERS.json";

if (!file_exists($FILENAME)) {
    die("skip Cannot find server list");
}
$json = file_get_contents($FILENAME);
$servers = json_decode($json);
if (!$servers) {
    exit("skip Couldn't json_decode(file_get_contents($FILENAME));");
}
def($servers);

$consts = array(
    "DATABASE_NAME"                 => "phongo",
    "COLLECTION_NAME"               => makeCollectionNameFromFilename($_SERVER["SCRIPT_FILENAME"]),
    "DEBUG_DIR"                     => sys_get_temp_dir() . "/PHONGO-TESTS/",
);
def($consts);

// These use values from constants defined above
$consts = array(
    "NS"                  => DATABASE_NAME . "." . COLLECTION_NAME,
    "DEBUG_FILENAME"      => DEBUG_DIR . DATABASE_NAME . "." . COLLECTION_NAME,
);
def($consts);



if (!is_dir(DEBUG_DIR)) {
    mkdir(DEBUG_DIR, 0777, true);
}

/* If the INI option hasn't been changed, then lets set it to the debug log */
$ininame = "phongo.debug_log";
$origin = ini_get($ininame);
ini_restore($ininame);
if ($ininame == $origin) {
    ini_set("phongo.debug_log", DEBUG_FILENAME);
    file_put_contents(DEBUG_FILENAME, sprintf("===> %s <=== %s\n", date(DATE_ISO8601), $_SERVER["SCRIPT_FILENAME"]), FILE_APPEND);
}


$_manager = new MongoDB\Driver\Manager(STANDALONE);
