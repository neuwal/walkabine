<?php

/**
 * Class JsonRepository
 */
class JsonRepository {

    public $collection;

    /**
     * @param $jsonFilePath
     */
    public function __Construct($jsonFilePath) {
        $this->readCollectionFromFile($jsonFilePath);

        $this->scrambleAnswers();
    }

    /**
     * @param $jsonFilePath
     * @throws Exception
     */
    private function readCollectionFromFile($jsonFilePath) {
        if (!file_exists($jsonFilePath)) {
            throw new Exception('file doesn\'t exist.');
        }
        $collection = json_decode(file_get_contents($jsonFilePath));
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