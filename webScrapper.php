<?php
include  ('simple_html_dom.php');

$html = file_get_html("http://estoremedia.space/DataIT/index.php?page=1");


foreach($html->find('div[class="card h-100"]') as $card){
    foreach($card as $cardEl){
        echo $html->find('a');
    }
}
  