# TODO ~> Required learning before structuring project / writing PHP code / programming or modifying MYSQL

* ## PHPUnit - unit testing in PHP
	* Write PHP unit tests for all OO code

* ## MVC - discover how to write within a primitive MVC pattern constraint in PHP
	* Decide what Base Models and Concrete models are required for the project
	* Decide what Controllers are required for the project (DB entity only?)
	* Decide what views are required for the project

* ## Character encoding - UTF-8
	* Research PDO method parameters (e.g: connect parameters) that ensure that the database is only supplied UTF-8 data OR otherwise ensure that mysqli is safe for use in UTF-8 character transactions
	* Look for global way of setting php script character encoding as an alternative to writing 'mb_internal_encoding(); mb_http_output();' at the top of every script
	* IN MYSQL set database and all subsequent tables to UTF-8 encoding

* ## MYSQL data
	* Find out how to include sample MYSQL data in docker build

* ## OO S.O.L.I.D
	* Single-responsibility principle ~> A single class should have a single job
	* Open/closed principle ~> Open to extension/closed to modification
	* Liskov's substitution principle ~> Subclass should be subsitutable for base class (have the same original methods and properties as the base class, even if modified)
	* Interface segregation principle ~> Ensure that each interface tries to only address an atomic concept (e.g: 'Car' implements 'Steering Wheel', 'Engine')
	* Dependency Inversion principle ~> Ensure that objects avoid concrete references to each other as much as possible
