<?php

declare(strict_types=1);
include '../getDataFromCsv.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

try {
    echo json_encode(
        array(
            "result" => getData()
        )
    );
} catch (Exception $e) {
    echo json_encode(
        array(
            "result" => $e->getMessage()
        )
    );
}