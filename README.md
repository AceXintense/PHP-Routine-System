# PHP Routine System
A simple PHP routine system built from the ground up.

## How do I use PHP Routine System?
Using PHP Routine System is extremely simple. To run the TestHarness.php routine write this command.

    php Routine.php test/TestHarness.php [Arguments]

[Arguments] Arguments allow the user to pass arguments to the routine in question. TestHarness has a main method inside of it which allows passing of arguments.

##Example

###Example Command

    php Routine.php test/TestHarness.php PHPRoutineSystem Development

###Example TestHarness

    TestHarness.php
    
    public function main($arguments) {
        print_r($arguments);
    }
    
###Example Output

    Array
    (
        [0] => PHPRoutineSystem
        [1] => Development
    )

    
## What can I do with this?
With this simple PHP routine system you can extend the functionality by adding new scripts to the system.

## How do I extend the functionality of the system?
Extending the functionality is extremely simple with all the code being documented the process should be easy to understand.

###Adding a new Routine
Adding a new Routine is simple just create the new routine in the home directory.

####Creation of the file
1. Create a new directory (optional) 
2. Create a new file (mandatory)


    mkdir newRoutines
    cd newRoutines
    touch NewRoutine.php

####After file creation
Open the file and use this template

    class NewRoutine implements RoutineInterface {
    
        public function main($arguments) {
            //Add all the routine code here.
        }
        
    }

####Calling the new Routine
Calling the routine is extremely easy as Routine.php handles the request.

    php Routine.php newRoutines/NewRoutine.php [Arguments]

## What is next for PHP Routine System?
Further development will include :

1. Auto loading of PHP classes.
2. Expanding the functionality of the routine script to allow more flexibility.