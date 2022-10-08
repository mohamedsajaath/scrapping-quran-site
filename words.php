<?php
set_time_limit(0);
$file_name = 'collection.json';
$collection = file_get_contents($file_name);

$collection = empty($collection) ? [] : json_decode($collection, true);


for ($d = 0; $d < 1; $d++) {
    print("main loop: " . $d ."<br/>");

    $data = file_get_contents("files/{$d}.txt");

    // words
    $pattern_for_verses_words = " /<div\sclass\=\"quranword\"[\d\D]*?<\/div>/i";
    preg_match_all($pattern_for_verses_words, $data, $verse_words);


    // printR($verse_words);

    for ($m = 0; $m < count($verse_words[0]); $m++) {
        print("    2nd layer loop: " . $m ."<br/>");

        // words filter
        $pattern_for_verses_words_filt = "  /<span\sclass\=\"transarabicword\">[\d\D]*?<\/span><\/span>/i";
        preg_match_all($pattern_for_verses_words_filt, $verse_words[0][$m], $verse_words_filt);

        $arr_collection = [];
        foreach ($verse_words_filt[0] as $each) {
            preg_match('/<span\sclass\=\"arabicword\">(.*?)<\/span>/i', $each, $arabic);
            preg_match('/<span\sclass\=\"transword\">(.*?)<\/span>/i', $each, $tamil);
            $arr_collection[] = [
                'arabic' => strip_tags($arabic[0]),
                'tamil' => strip_tags($tamil[0])
            ];
        }
        $collection[$d]['verses'][$m]['each_word'] = $arr_collection;
        file_put_contents($file_name,json_encode($collection));
    }
}

echo "<pre>";
print_r($collection);
echo "</pre>";
