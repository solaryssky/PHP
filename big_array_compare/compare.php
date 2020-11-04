<?php
echo "\n Memory Consumption is   ";
echo round(memory_get_usage()/1048576,2).''.' MB';

//читаем 1 файл в массив
$a = file("random_1.csv");
//читаем 2 файл в массив
$b = file("random_2.csv");

//функция для вычисления расхождений 1 массива от 2 массива
function large_array_diff($b, $a){
    // меняем наборот в 1 массиве ключ и значение
    $at = array_flip($a);
	// меняем наборот во 2 массиве ключ и значение
    $bt = array_flip($b);
    //вычисляем расхождение массивов сравнивая ключи
    $d = array_diff_key($bt, $at);
    //возвращаем в функции массив-результат сравнения ключей
    return array_keys($d);
}
//выполянем функцию подставляя массивы в качестве аргументов
$diff = large_array_diff($b, $a);
//пишем результат сравнения в файл
file_put_contents('compare_diff.csv', $diff, FILE_APPEND);


echo "\n Memory Consumption is   ";
echo round(memory_get_usage()/1048576,2).''.' MB';
