<?php

declare(strict_types=1);
ini_set('display_errors', 1);

include('simple_html_dom.php');

function getJsonData($card)
{
    $jsonData = $card->find('script', 0)->innertext;
    $decodedData =  json_decode($jsonData, true)['products'];
    return $decodedData;
}


function scrapArticleData(string $articleHref)
{

    $html = file_get_html($articleHref);
    $productCard = 'div[class="card h-100"]';
    static $product = [];

    foreach ($html->find($productCard) as $i => $card) {
        $product['data']['code'] =   getJsonData($card)['code'];
        $product['data']['imgLink'] = $card->find('img[class="card-img-top"]', 0)->src;
        $product['data']['rating'] = strval(substr($card->find('small[class="text-muted"]')[0]->innertext, 0, strpos($card->find('small[class="text-muted"]')[0]->innertext, " ")));
        $product['data']['reviewsQty'] = strstr($card->find('small[class="text-muted"]')[0]->innertext, " ");
        if ((!empty(getJsonData($card)['variants']))) {

            foreach (getJsonData($card)['variants'] as $i => $variant) {
                $product['data']['variantData'][$i]['title' . "$i"] = $card->find('p[class=card-text]', 0)->innertext . ' #' . "$i";
                if (empty($variant['price_old'])) {
                    $product['data']['variantData'][$i]['price' . "$i"] = $variant['price'];
                    $product['data']['variantData'][$i]['oldPrice' . "$i"] = "";
                } else {
                    $product['data']['variantData'][$i]['price' . "$i"] = $variant['price'];
                    $product['data']['variantData'][$i]['oldPrice' . "$i"] = $variant['price_old'];
                }
            }
        } else {
            $product['data']['variantData']['Variant 1']['titleVariant 1'] = $card->find('p', 0)->innertext;
        }
        if ((!empty($card->find('del[price-old]', 0)))) {
            $product['data']['variantData']['Variant 1']['priceVariant 1'] = $card->find('span[class=price]', 0)->innertext;
            $product['data']['variantData']['Variant 1']['oldPriceVariant 1'] = "0";
        } else {
            $product['data']['variantData']['Variant 1']['priceVariant 1'] = $card->find('span[class=price-promo]', 0)->innertext;
            $product['data']['variantData']['Variant 1']['oldPriceVariant 1'] = $card->find('del[class=price-old]', 0)->innertext;
        }
    }

    return $product;
}

function saveDataToFile($href)
{
    $file = fopen(__DIR__ . "/Api/articleData.csv", "w+");
    fputcsv($file, ['title', 'oldprice', 'price', 'code', 'imgLink', 'rating', 'reviewsQty']);
    $n = 1;
    foreach (scrapArticleData($href) as $articleData) {
        foreach ($articleData['variantData'] as $variant) {
            fputcsv($file, [
                $variant['titleVariant ' . $n],
                $variant['oldPriceVariant ' . $n],
                $variant['priceVariant ' . $n],
                $articleData['code'],
                $articleData['imgLink'],
                $articleData['rating'],
                $articleData['reviewsQty']
            ]);
            $n++;
        }
    }
    fclose($file);
}

function getData($href)
{
    saveDataToFile($href);
    $file = fopen(__DIR__ . '/Api/articleData.csv', 'r');
    fgetcsv(($file));
    $productData = [];
    while (($line = fgetcsv($file)) !== FALSE) {
        array_push($productData, $line);
    }
    fclose($file);
    return $productData;
}
