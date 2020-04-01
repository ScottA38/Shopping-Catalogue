# **TODO** ~> Required learning before structuring project / writing PHP code / programming or modifying MYSQL

* ## PHPUnit - unit testing in PHP
	* Learn how to use PHPUnit library in order to test all OO code

* ## Coding standards
	* ~~Read in detail about [PSR-4](https://www.php-fig.org/psr/) and how to adhere to this coding specification~~ _Using [`phpcs`](https://packagist.org/packages/squizlabs/php_codesniffer) to help lint code then fix manually_
	* ~~Read [clean code](https://github.com/jupeter/clean-code-php) in full~~ Too extensive for scope, excluded

* ## MVC - discover how to write within a primitive MVC pattern constraint in PHP
	#### Use [.these.](https://code.tutsplus.com/tutorials/mvc-for-noobs--net-10488) [.resources.](https://www.sitepoint.com/the-mvc-pattern-and-php-1/) to understand MVC and implement the pattern in PHP

	* ~~Decide what Base Models and Concrete models are required for the project~~ _See `docs/entities.md`_
	* Decide what Controllers are required for the project ~~(DB entity only?)~~
	* ~~Decide what views are required for the project~~ _See `docs/entities.md`_

* ## Security
	*  **Character encoding** - UTF-8
		* ~~Look for global way of setting php script character encoding as an alternative to writing `mb_internal_encoding(); mb_http_output();` at the top of every script~~ Even if possible in `Apache .htaccess`, it is not reccomended as it can still create bugs. Ensure that `mb_internal_encoding(); mb_http_output();` is written at the top of every php script (FIND RESOURCE saying this)
		* IN MYSQL set database and all subsequent tables to UTF-8 encoding
	* **Learn how to write MySQLi prepared statements in order to prevent injection attacks**

* ## Error handling
	* Determine best practise of error handling declarations and whether to use xdebug.scream

* ## MYSQL data
	* Find out how to include sample MYSQL data in docker build
		* Explore [`fzaninotto/faker`](https://packagist.org/packages/fzaninotto/faker) to see if a database seeder is possible OR
		* Use '[Maximilian Schwarzmuller's project](https://github.com/mschwarzmueller/laravel-shopping-cart-tutorial)' as a reference and use the same implementation if `Illuninate` library can be used
	* Find an appropriate ORM to use
		* Options:
			* Propel (in alpha)
	* Consider using DB abstraction layer (e.g: [Doctrine2 DBAL](https://www.doctrine-project.org/projects/dbal.html))

* ## View templating
	* Explore the viability of `[twig](https://packagist.org/packages/twig/twig)` for the project

* ## OO S.O.L.I.D
	* Single-responsibility principle ~> A single class should have a single job
	* Open/closed principle ~> Open to extension/closed to modification
	* Liskov's substitution principle ~> Subclass should be subsitutable for base class (have the same original methods and properties as the base class, even if modified)
	* Interface segregation principle ~> Ensure that each interface tries to only address an atomic concept (e.g: 'Car' implements 'Steering Wheel', 'Engine')
	* Dependency Inversion principle ~> Ensure that objects avoid concrete references to each other as much as possible
