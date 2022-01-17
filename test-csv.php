<?php

use app\utils\CSVFileConverter;
use app\exceptions\FileFormatException;
use app\exceptions\SourceFileException;

require_once "vendor/autoload.php";

$columns_city = ['name', 'lat', 'longitude'];
$columns_category = ['name', 'icon'];

$converters[] = new CSVFileConverter('data/cities.csv', 'city', $columns_city);
$converters[] = new CSVFileConverter('data/categories.csv', 'category', $columns_category);

foreach ($converters as $key => $converter) {
    $fileName = 'query-' . $key . '.sql';
    try {
        $converter->writeSql($fileName);
    }
    catch (SourceFileException $ex) {
        echo "Не удалось обработать csv файл: " . $ex->getMessage();
    }
    catch (FileFormatException $ex) {
        echo "Неверный формат файла импорта: " . $ex->getMessage();
    }
}
