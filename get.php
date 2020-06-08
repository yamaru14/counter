<?php
//ini_set('display_errors', "On");

define('DATA_FILE', 'data.text');

$count = getCounter(DATA_FILE);

header('Counter-type: application/json');
echo json_encode([
        'status' => true,
        'count' => $count
]);

function getCounter($file){
    $fp = fopen($file, 'r+');
    flock($fp, LOCK_EX);
    $buff = (int)fgets($fp);

    ftruncate($fp, 0);
    fseek($fp, 0);

    fwrite($fp, $buff+1);

    flock($fp, LOCK_UN);
    fclose($fp);

    return($buff);
}