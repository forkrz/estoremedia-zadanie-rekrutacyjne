<?php

declare(strict_types=1);
include('simple_html_dom.php');

function scrapDataOnOnePage(int $i)
{
    $html = file_get_html("http://estoremedia.space/DataIT/index.php?page=" . $i);
    $productCard = 'div[class="card h-100"]';
    static $products = [];

    foreach ($html->find($productCard) as $i => $card) {
        $products["product" . $i] = [
            'title' => $card->find('a[class="title"]', 0)->{'data-name'},
            'detailsLink' => "http://estoremedia.space/DataIT/" . $card->find('a[class="title"]', 0)->href,
            'imgLink' =>    $card->find('img[class="card-img-top"]', 0)->src,
            'price' =>  $card->find('h5')[0]->innertext,
            'rating' => strval(substr($card->find('small[class="text-muted"]')[0]->innertext, 0, strpos($card->find('small[class="text-muted"]')[0]->innertext, " "))),
            "reviewsQty" => strstr($card->find('small[class="text-muted"]')[0]->innertext, " ")
        ];
    }

    return $products;
}


function getNrOfPages(): string
{
    $html = file_get_html("http://estoremedia.space/DataIT/index.php?page=1");
    $arr = [];
    foreach ($html->find('a[class="page-link next"]') as $el) {
        array_push($arr, $el->{'data-page'});
    }
    return max($arr);
}

function getAllArticles(): array
{
    $products = [];
    for ($i = 1; $i <= getNrOfPages(); $i++) {
        array_push($products, scrapDataOnOnePage($i));
    }
    return $products;
}

function saveDataInCsvFile()
{
    if(file_exists('../Api/data.csv')){
        unlink('../Api/data.csv');
    };    
    $file = fopen(__DIR__ . "/Api/data.csv", "w+");
    fputcsv($file, ['title', 'detailsLink', 'imgLink', 'price', 'rating', 'reviewsQty']);
    foreach (getAllArticles() as $pageArray) {
        foreach ($pageArray as $articleData) {
            fputcsv($file, [
                $articleData['title'], $articleData['detailsLink'],
                $articleData['imgLink'],
                $articleData['price'],
                $articleData['rating'],
                $articleData['reviewsQty']
            ]);
        }
    }
    fclose($file);
}
