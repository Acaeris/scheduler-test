# Single Manning Calculation

This project calculates the number of minutes each member of staff works solo by rota ID.

To run the tests, in the root of the project type:

`composer install && bin/phpspec r`

The scenarios are documented and tested in the `spec\Scheduler\Processor\SingleManningProcessorSpec` file, including a
fourth scenario tested where I made sure that it could calculate the total number of minutes worked if a staff member 
had two separate periods working solo in the same shift. This passed after creation and needed no additional work on 
the code.

Although there is a Dockerfile, this was a part of my Symfony skeleton project used as a starting point and it does not
set up the required MySQL tables or example data. If you wish to set this up locally, you will need to amend the 
`app\config\config.yml` values for Doctrine. There is also 
an example implementation in `Scheduler\Command\SoloWorkReportCommand`. This can be run using:

`php bin\console report:soloWork <rotaId>`