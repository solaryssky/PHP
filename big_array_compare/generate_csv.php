<?php

for ($i = 1; $i <= 1000000; $i++) {
    $string = bin2hex(random_bytes(10)); // 20 characters, only 0-9a-f
	$csv = $string.';'.$string.';'.$string.';'.$string.';'.$string.';'.$string.';'.$i."\n";
	file_put_contents('random_2.csv', $csv, FILE_APPEND);
}