<?php
$file_name = 'collection.json';
$collection = file_get_contents($file_name);

$collection = empty($collection) ? [] : json_decode($collection, true);

for ($d = 0; $d < 114; $d++) {

    // title
    $data = file_get_contents("files/{$d}.txt");

    $pattern_for_sura_title = "/<span\sclass\=\"suratitle\">[\d\D]*?<\/span>/i";
    preg_match_all($pattern_for_sura_title,  $data, $title);

    $pattern_for_sura_title_filt = "/>[\d\D]*?<br>/i";
    preg_match_all($pattern_for_sura_title_filt, $title[0][0], $title_filt);

    $patter_for_plain_text = "/\>\d+\.(.*)<br>/i";
    preg_match($patter_for_plain_text, $title_filt[0][0], $plain_title);


    $arr = [
        'chapter' => $d + 1,
        'title' => $plain_title[1]
    ];
    $collection[$d] = $arr;
    
    print_r($collection);
    echo "\n";
}
// echo "FINAL\n<pre>";
// print_r($collection);
// echo "</pre>";



file_put_contents($file_name, json_encode($collection));
