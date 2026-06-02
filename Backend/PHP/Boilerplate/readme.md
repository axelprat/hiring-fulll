# Requirements
To run this project you will need a computer with PHP and composer installed.

Optionally if docker is installed you can use the commands in the Makefile to start the project in a docker instance.

# Install
To install the project, you just have to run `composer install` to get all the dependencies.

While using docker you just need to run `make up-full` the first time and `make up` after that. 

# Running the tests
After installing the dependencies you can run the tests with this command `vendor/behat/behat/bin/behat`.
The result should look like this :
![behat.png](behat.png)