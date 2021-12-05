<?php
namespace app\models;
use app\exceptions\FileFormatException;
use app\exceptions\SourceFileException;

class CSVFileConverter {
    private $filename;
    private $tableName;
    private $columns;

    private $fileObject;
    private $tableValues;
    private $sqlFileName;

    public function __construct(string $filename, string $tableName, array $columns)
    {
        $this->filename = $filename;
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

//        Создает массив из значений ячеек, записывает его в $tableValues
    public function import(): void {
    }

//        Создает файл sql с именем таблицы, записывает путь к нему в $sqlFileName
    public function write(): void {
    }

//    Возвращает путь к sql файлу с запросами на запись данных
    public function getSQLFile(): ?string {
        return $this->sqlFileName;
    }

//    Возвращает заголовки столбцов таблицы
    private function getHeaderData(): ?array {}

//    Возвращает массив значений очередной строки таблицы
    private function getNextLine(): ?array {}

    private function validateColumns(array $columns): bool {}
}
