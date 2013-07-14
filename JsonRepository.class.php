<?php

/**
 * Class JsonRepository
 */
class JsonRepository {

    public $collection;

    /**
     * @param $jsonFilePath
     * @param bool $scrambleAnswers
     */
    public function __Construct($jsonFilePath, $scrambleAnswers = true) {
        $this->readCollectionFromFile($jsonFilePath);

        if ($scrambleAnswers) {
            $this->scrambleAnswers();
        }
    }

    /**
     * @param $jsonFilePath
     * @throws Exception
     */
    private function readCollectionFromFile($jsonFilePath) {
        if (!file_exists($jsonFilePath)) {
            throw new Exception('file doesn\'t exist.');
        }
        if (!is_readable($jsonFilePath)) {
            throw new Exception('file isn\'t readable.');
        }
        $fileContents = file_get_contents($jsonFilePath);
        if ($fileContents === false) {
            throw new Exception('cannot get file contents.');
        }
        if (!mb_check_encoding($fileContents, 'UTF-8')) {
            throw new Exception('file contents is not UTF-8');
        }
        $collection = json_decode($fileContents);
        if ($collection === null) {
            throw new Exception('file cannot be decoded');
        }
        $this->collection = $collection;
    }

    /**
     *
     */
    private function scrambleAnswers() {
        //todo
    }
}