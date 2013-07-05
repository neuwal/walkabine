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