<?php

declare(strict_types=1);

function getData()
{
    $file = fopen('../Api/data.csv', 'r');
    fgetcsv(($file));
    $products = [];
    while (($line = fgetcsv($file)) !== FALSE) {
        array_push($products, $line);
    }
    fclose($file);
    return $products;
}
