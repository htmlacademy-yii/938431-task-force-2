<?php
namespace app\utils;
use app\exceptions\FileFormatException;
use app\exceptions\SourceFileException;

class CSVFileConverter {
    private $filename;
    private $tableName;
    private $columns;
    private $fileObject;
    private $resultData;

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
        if ($header_data != $this->columns) {
            throw new FileFormatException("Исходный файл не содержит необходимых столбцов");
        }

        try {
            $sqlFileObject = new \SplFileObject($sqlFileName, "w");
            $this->importData();
            if (!empty($this->resultData)) {
                $query = $this->createSqlQuery();
                if ($query) {
                    $sqlFileObject->fwrite($query);
                }
            }
        }
        catch (\RuntimeException $ex) {
            throw new SourceFileException("Не удалось открыть файл для записи");
        }
    }

    //   Возвращает заголовки столбцов таблицы
    private function getHeaderData(): ?array {
        $this->fileObject->rewind();
        $res = $this->fileObject->fgetcsv();
        if(substr($res[0], 0, 3) == pack('CCC', 0xef, 0xbb, 0xbf)) {
            $res[0] = substr($res[0], 3);
        }
        return $res;
    }

    //   Возвращает массив значений очередной строки таблицы
    private function getNextLine(): ?iterable {
        while (!$this->fileObject->eof()) {
            yield $this->fileObject->fgetcsv();
        }
    }

    private function importData(): void {
        foreach ($this->getNextLine() as $line) {
            if (!$line[0]) {
                continue;
            }
            foreach ($line as &$value) {
                $value = '"' . $value . '"';
            }
            unset($value);
            $this->resultData[] = "(" . implode(', ',$line) . ")";
        }
    }

    //  Создает запрос на запись в таблицу на основании импортированных данных
    private function createSqlQuery(): string {
        $columns = implode(',', $this->columns);
        $values = implode(', ', $this->resultData);
        return "INSERT INTO " . $this->tableName . " (" . $columns . ") VALUES" . $values . ";" . PHP_EOL;
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
