<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



$ch = curl_init('URL TO YML YANDEX');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$html = curl_exec($ch);
curl_close($ch);
file_put_contents(__DIR__ . '/file.xml', $html);
 
$data = simplexml_load_file(__DIR__ . '/file.xml');

setlocale(LC_ALL, 'ru_RU');
date_default_timezone_set('Europe/Moscow');
header('Content-Type: text/xml; charset=utf-8');
$url = 'https://site.ru';

$feed = '<?xml version="1.0" encoding="UTF-8"?>
     <rss xmlns:yandex="http://news.yandex.ru"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:turbo="http://turbo.yandex.ru"
     version="2.0">
     <channel>
        <title>Здесь заголовок</title>
        <link>'.$url.'</link>
        <description>Описание</description>
        <language>ru</language>
        <turbo:analytics type="Yandex" id="000000"></turbo:analytics>
        <yandex:related type="infinity">
        ';

foreach ($data->shop->offers->offer as $row) {
	$url_product = strval($row->url);
	$url_product = htmlspecialchars($url_product, ENT_XML1, 'UTF-8');
	$name_product = strval($row->name);	
	$name_product = htmlspecialchars($name_product, ENT_XML1, 'UTF-8');	
	$feed .= '<link url="'.$url_product.'">'.$name_product.'</link>';
}		

$feed .= '</yandex:related>';

$category = [];
foreach ($data->shop->categories->category as $row) {

	$id = intval($row['id']);
	$name = strval($row);
	$category[$id] = $name;

}

foreach ($data->shop->offers->offer as $row) {
		
		$url_product = strval($row->url);
		$url_product = htmlspecialchars($url_product, ENT_XML1, 'UTF-8');
	    $name_product = strval($row->name);	
	    $name_product = htmlspecialchars($name_product, ENT_XML1, 'UTF-8');	
		$category_product_id = strval($row->categoryId);	
		$picture_product = strval($row->picture);
		$description_product = strval($row->description);
		$price = strval($row->price);	
		

	$feed .= '
            <item turbo="true">        
                <link>'.$url_product.'</link>
                <author>Дмитрий Кузьмин</author>
                <category>'.$category[$category_product_id].'</category>
                <turbo:source>'.$url_product.'</turbo:source>
                <turbo:topic>Turbo '.$category[$category_product_id].' '.$name_product.'</turbo:topic>
                <pubDate>'.date(DATE_RFC822).'</pubDate>
                <turbo:content>
                    <![CDATA[
                        <header>
                            <h1>' . $name_product.' '.$price.'р. + бесплатная доставка</h1>
                            <figure>
                           		<img src="'.$picture_product.'">
                        	</figure>
                        </header>
                        ' . $description_product . '
						 ]]>
                </turbo:content>
            </item>';

	
	
	
	
}
	

	$feed .= '
    </channel>
    </rss>';

file_put_contents(__DIR__ .'/yandex_turbo.xml', $feed);
echo $feed;
		
