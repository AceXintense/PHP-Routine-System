<?php

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2/4/17
 * Time: 1:26 AM
 */
class Queue {

    //File path to the queue json data.
    CONST FILE_PATH = (__DIR__ . '/../data/queue.json');

    //Local queue.
    private $queue = [];


    /**
     * Add a routine to the queue.
     * @param $class
     */
    public function addToQueue($class) {
        $this->queue[$class] = $class;
        $this->setQueueFromFile();
        $this->writeToFile();
    }

    /**
     * Clear the queue and update the queue json.
     */
    public function clearQueue() {
        $this->queue = [];
        $this->writeToFile();
    }

    /**
     * Remove a routine from the queue.
     * @param $class
     * @throws Exception
     */
    public function removeFromQueue($class) {

        if (empty($this->queue[$class])) {
            throw new Exception('Class ' . $class . ' not found in the queue.');
        }

        unset($this->queue[$class]);
        $this->setQueueFromFile();
        $this->removeFromFile($class);
    }

    /**
     * Get the routine queue array.
     * @return array
     */
    public function getQueue() {
        return $this->queue;
    }


    /**
     * Remove from the JSON on the file.
     * @param $class
     */
    private function removeFromFile($class) {
        $fileArray = $this->getQueueFileArray();
        unset($fileArray[$class]);
        $this->writeToFile($fileArray);
    }

    /**
     * Write the queue to the JSON file.
     * @param array $data
     */
    private function writeToFile($data = null) {
        if (is_null($data)) {
            $data = $this->queue;
        }
        $json = json_encode($data);
        $file = fopen(self::FILE_PATH, 'w');
        fwrite($file, $json);
        fclose($file);
    }

    /**
     * Get the JSON array from the file.
     * @return mixed|null
     */
    private function getQueueFileArray() {
        if (file_exists(self::FILE_PATH)) {
            $json = file_get_contents(self::FILE_PATH);
            return json_decode($json, true);
        }
        return null;
    }

    /**
     * Override the local queue with the merged JSON file array.
     */
    public function setQueueFromFile() {
        $oldQueue = $this->getQueueFileArray();
        if (!is_null($oldQueue)) {
            $this->queue = array_merge($oldQueue, $this->queue);
        }
    }

}

//Create a new instance of Queue.
$instance = new Queue();