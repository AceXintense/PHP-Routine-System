<?php

//Include all the required php files.
include_once('lib/RoutineInterface.php');
include_once('lib/Arguments.php');
/**
 * Created by Sam Grew.
 * User: developer
 * Date: 2/3/17
 * Time: 9:40 PM
 */
class Routine extends Arguments {

    /**
     * Routine constructor.
     * @internal param $arguments
     * @param $arguments
     * @throws Exception
     */
    public function __construct($arguments) {

        $this->setQueueFromFile();

        //Set the arguments passed to the Routine.php script.
        $this->setArguments($arguments);
        $this->shiftArguments();

        //Add a routine to the queue.
        if (strtolower(current($this->getArguments())) == 'add-to-queue') {

            $this->shiftArguments();
            $this->addToQueue(current($this->getArguments()));
            print(current($this->getArguments()) . ' Added to the routine queue.');
            exit;

        }

        //Remove a routine from the queue.
        if (strtolower(current($this->getArguments())) == 'remove-from-queue') {

            $this->shiftArguments();
            try {
                $this->removeFromQueue(current($this->getArguments()));
                print(current($this->getArguments()) . ' Removed from the queue.');
                exit;
            } catch (Exception $e) {
                die(print_r($e->getMessage()));
            }

        }

        //Get the queue's array structure.
        if (strtolower(current($this->getArguments())) == 'get-queue') {

            if (empty($this->getQueue())) {
                die('The queue is empty.');
            }

            $this->shiftArguments();
            print_r($this->getQueue());
            exit;

        }

        //Clear the queue.
        if (strtolower(current($this->getArguments())) == 'clear-queue') {

            if (empty($this->getQueue())) {
                die('There is nothing in the queue to clear.');
            }

            $this->shiftArguments();
            $this->clearQueue();
            exit;

        }

        //Run all the routines in the queue.
        if (strtolower(current($this->getArguments())) == 'run-queue') {

            if (empty($this->getQueue())) { //Check the queue for items.
                die('There is nothing in the queue to run.');
            }

            $this->shiftArguments(); //Shift arguments so that we only give the routine the arguments after the name.
            foreach ($this->getQueue() as $item) { //Loop over the queue and call the routines.
                $routine = $this->getRoutine($item);
                $routine->main($this->getArguments()); //Call the main() function on the object.
            }

            $finalise = readline('Would you like to clear the queue? [Y/n]'); //Give the option to clear the queue defaults to yes.
            if (strtolower($finalise) != 'n') {
                $this->clearQueue();
            }
            exit;

        }

        try {
            $routine = $this->getRoutine();
            $this->shiftArguments(); //Shift arguments so that we only give the routine the arguments after the name.
            $routine->main($this->getArguments()); //Call the main() function on the object.
        } catch (Exception $e) {
            die(print_r($e->getMessage())); //Throw the exception at the user.
        }

    }

    /**
     * Gets the routine from the arguments. [php Routines.php TestHarness.php]
     * @param null $class
     * @return mixed
     * @throws Exception
     */
    private function getRoutine($class = null) {

        if (is_null($class)) {
            $class = current($this->getArguments()); //Get the first element in the arguments array.
        }

        if (!strpos($class, '.php')) { //Checks the string to see if .php exists as a substring.
            $class = $class . '.php'; //Append .php to the end of the string.
        }

        $regex = '/(\S+\/)(\w+.php)/'; //$1 = Directory (/home/dev/) $2 = PHPFile (TestHarness.php)
        $className = preg_replace($regex, '$2', $class); //Get the class name from the string.

        if (strpos($className, '.php')) { //Checks the string to see if .php exists as a substring.
            $className = str_replace('.php', '', $className); //Remove .php from the string so that the className is correct.
        }

        if (file_exists($class)) { //Check to see if the class is actually there.
            //Includes the routine that is going to be initialized.
            include_once($class);
            $instance = new $className(); //Create the routine instance.
            return $instance;
        }

        throw new Exception("No routine found with the name of $className");

    }

}

//Create the routine and pass the arguments to the object.
$routine = new Routine($argv);