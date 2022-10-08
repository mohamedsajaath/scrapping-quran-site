<?php

$file_name= 'collection.json';
$collection = file_get_contents($file_name);

$collection = empty($collection) ? [] : json_decode($collection,true);

//  arabic-tamil
for ($d = 0; $d < 1; $d++) {

    $data = file_get_contents("files/{$d}.txt");


    $pattern_for_sura_verses_arabic_tamil = "/<span\sclass\=\"ayaNum\"[\d\D]*?<\/span><\/div>/i";
    preg_match_all($pattern_for_sura_verses_arabic_tamil, $data, $verse_arabic_tamil);
    
    $count = 1;
    $arr = [];
    foreach ($verse_arabic_tamil[0] as $each) {
        $each = strip_tags(preg_replace('/[\:\d\.]/i','',$each));
        if ($count % 2 == 1) {
            
            $arr['arabic_full_text'] = $each;
        }else{
            $arr['tamil_full_text'] = $each;
        }
        $count++;

        if(sizeof($arr) == 2){
            $collection[$d]['verses'][] = $arr;
            $arr = [];
        }
    }

}

echo "<pre>";
print_r($collection);
echo "</pre>";

file_put_contents($file_name,json_encode($collection));
