<?php

use app\utils\CSVFileConverter;
use app\exceptions\FileFormatException;
use app\exceptions\SourceFileException;

require_once "vendor/autoload.php";

$columns = [
    'id',
    'login',
    'email',
    'password',
    'avatar',
    'create_at',
    'birthdate',
    'info',
    'phone',
    'telegram',
    'user_role',
    'city_id',
    ];
$converter = new CSVFileConverter('data/user.csv', 'user', $columns);

try {
    $converter->writeSql('queries.sql');
}
catch (SourceFileException $ex) {
    echo "Не удалось обработать csv файл: " . $ex->getMessage();
}
catch (FileFormatException $ex) {
    echo "Неверный формат файла импорта: " . $ex->getMessage();
}
