
<?php

$file = file_get_contents('collection.json');

set_time_limit(0);

$url = "http://www.tamililquran.com/suraindex.php";

$data  = curl_get_data($url);

$pattern_for_exract_div = '/<div\sclass\=\"tab\-content\"\>[\d\D]*?<\/div/i';
preg_match_all($pattern_for_exract_div, $data, $extracted_div_content);


// extract link
$patter_for_exstract_links = '/qurandisp\.php\?start\=[\d]*"/i';
preg_match_all($patter_for_exstract_links, $extracted_div_content[0][0], $link_non_filtered);


$links = [];

for ($i = 0; $i < count($link_non_filtered[0]); $i++) {
    $link = preg_replace('/[\"]/i', '', $link_non_filtered[0][$i]);
    array_push($links, $link);
}


for ($d = 0; $d < count($links); $d++) {

    $page_link = "http://www.tamililquran.com/" . $links[$d];

    $data2 = curl_get_data( $page_link);




     $locate = dirname(__FILE__);
    $name = $locate."/files/$d.txt";

  
    file_put_contents($name,file_get_contents($page_link));


}




function printR($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function curl_get_data($url)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $data  = curl_exec($curl);
    curl_close($curl);

    return $data;
}









