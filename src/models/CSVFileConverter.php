<?php
namespace app\models;
use app\exceptions\FileFormatException;
use app\exceptions\SourceFileException;

class CSVFileConverter {
    private $filename;
    private $tableName;
    private $columns;
    private $fileObject;

    public function __construct(string $filename, string $tableName, array $columns)
    {
        $this->filename = $filename;
        $this->tableName = $tableName;
        $this->columns = $columns;
    }

    //  Записывает sql запросы в файл с переданным именем
    public function writeSql(string $sqlFileName): void {
        if (!$this->validateColumns($this->columns)) {
            throw new FileFormatException("Заданы неверные заголовки стобцов");
        }

        if (!file_exists($this->filename)) {
            throw new SourceFileException("Файл c полученным именем не существует");
        }

        try {
            $this->fileObject = new \SplFileObject($this->filename, 'r');
        }
        catch (\RuntimeException $ex) {
            throw new SourceFileException("Не удалось открыть файл для чтения");
        }

        $header_data = $this->getHeaderData();
        if ($header_data !== $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        try {
            $sqlFileObject = new \SplFileObject($sqlFileName, "w");
            foreach ($this->getNextLine() as $line) {
                $query = $this->createSqlQuery($line);
                $sqlFileObject->fwrite($query);
            }
        }
        catch (\RuntimeException $ex) {
            throw new SourceFileException("Не удалось открыть файл для записи");
        }
    }

    //   Возвращает заголовки столбцов таблицы
    private function getHeaderData(): ?array {
        $this->fileObject->rewind();
        return $this->fileObject->getcsv();
    }

    //   Возвращает массив значений очередной строки таблицы
    private function getNextLine(): ?iterable {
        $result = null;
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
        return $result;
    }
    //  Создает запрос на запись в таблицу на основании одной строки данных
    private function createSqlQuery(array $line): string {
        $columns = implode(',', $this->columns);
        $values = implode(',', $line);
        return "INSERT INTO " . $this->tableName . " (" . $columns . ") VALUES(" . $values . ");" . PHP_EOL;
    }

    private function validateColumns(array $columns): bool {
        $result = true;
        if (count($columns)) {
            foreach ($columns as $column) {
                if (!is_string($column)) {
                    $result = false;
                    break;
                }
            }
        } else {
            $result = false;
        }
        return $result;
    }
}
