<?php

/**
 * Created by Sam Grew.
 * User: developer
 * Date: 2/3/17
 * Time: 9:41 PM
 */
class Arguments {

    //Argument Variables
    private $arguments = [];
    private $removedArguments = [];

    /**
     * Sets the arguments for the object.
     * @param $arguments
     */
    public function setArguments($arguments) {
        $this->arguments = $arguments;
    }

    /**
     * Gets the arguments for the object.
     * @return mixed
     */
    public function getArguments() {
        return $this->arguments;
    }

    /**
     * Gets all the removed arguments from the arguments array.
     * @return array
     */
    public function getRemovedArguments() {
        return $this->removedArguments;
    }

    /**
     * Removes all the removed arguments and applies them to the arguments array.
     */
    public function restoreRemovedArguments() {
        $this->setArguments(array_merge($this->arguments, $this->removedArguments));
        $this->removedArguments = [];
    }

    /**
     * Shifts the arguments array once.
     */
    public function shiftArguments() {
        $this->removedArguments[] = array_shift($this->arguments);
    }

}
//Create the instance for the Routines.
$instance = new Arguments();