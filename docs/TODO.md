# TODO ~> Required learning before structuring project / writing PHP code / programming or modifying MYSQL

* ## PHPUnit - unit testing in PHP
	* Write PHP unit tests for all OO code

* Coding standards
	* Read in detail about [PSR-4](https://www.php-fig.org/psr/) and how to adhere to this coding specification
	* Read [clean code](https://github.com/jupeter/clean-code-php) in full

* ## MVC - discover how to write within a primitive MVC pattern constraint in PHP
	#### Use [.these.](https://code.tutsplus.com/tutorials/mvc-for-noobs--net-10488) [.resources.](https://www.sitepoint.com/the-mvc-pattern-and-php-1/) to understand MVC and implement the pattern in PHP

	* Decide what Base Models and Concrete models are required for the project
	* Decide what Controllers are required for the project (DB entity only?)
	* Decide what views are required for the project

* ## Security
	* ### Character encoding - UTF-8
		* Look for global way of setting php script character encoding as an alternative to writing 'mb_internal_encoding(); mb_http_output();' at the top of every script
		* IN MYSQL set database and all subsequent tables to UTF-8 encoding
	* Learn how to write MySQLi prepared statements in order to prevent injection attacks

* ## Error handling
	* Determine best practise of error handling declarations and whether to use xdebug.scream

* ## MYSQL data
	* Find out how to include sample MYSQL data in docker build

* ## OO S.O.L.I.D
	* Single-responsibility principle ~> A single class should have a single job
	* Open/closed principle ~> Open to extension/closed to modification
	* Liskov's substitution principle ~> Subclass should be subsitutable for base class (have the same original methods and properties as the base class, even if modified)
	* Interface segregation principle ~> Ensure that each interface tries to only address an atomic concept (e.g: 'Car' implements 'Steering Wheel', 'Engine')
	* Dependency Inversion principle ~> Ensure that objects avoid concrete references to each other as much as possible
