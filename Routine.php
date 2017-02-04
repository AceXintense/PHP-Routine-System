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

        //Set the arguments passed to the Routine.php script.
        $this->setArguments($arguments);
        $this->shiftArguments();

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
     * @return mixed
     * @throws Exception
     */
    private function getRoutine() {

        $class = current($this->getArguments()); //Get the first element in the arguments array.

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