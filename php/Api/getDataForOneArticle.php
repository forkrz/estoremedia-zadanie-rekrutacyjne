<?php
declare(strict_types=1);
include '../getDataForOneArticle.php';
ini_set('display_errors', 1);
echo "current user: ".get_current_user();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$data = json_decode((file_get_contents("php://input")), true);
echo $data;
try {
    return json_encode(
        array(
            "result" => getData("http://estoremedia.space/DataIT/product.php?id=2006623401")
        )
    );
} catch (Exception $e) {
    return json_encode(
        array(
            "result" => $e->getMessage()
        )
    );
}