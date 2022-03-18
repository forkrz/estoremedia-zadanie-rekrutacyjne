<?php

declare(strict_types=1);
include '../getDataForOneArticle.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode((file_get_contents("php://input")), true);

try {
    echo json_encode(
        array(
            "result" => getData($data['href'])
        )
    );
} catch (Exception $e) {
    echo json_encode(
        array(
            "result" => $e->getMessage()
        )
    );
}