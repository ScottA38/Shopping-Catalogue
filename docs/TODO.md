# Outstanding development tasks

## Security

- [x] Put all database connection parameters in a secret file deeper in the server file hierarchy
	- [x] Ensure that all views which require the database connection parameters can read the hidden file in order to connect to the database

## Views

- [x] Research into/decide whether the view can be polymorphic (supports display of objects regardless of type)
- [x] Implement tests - *configured tests to ensure HTML output validity from methods**
- [x] Implement `ProductView` view base class

## Webpages

- [x] Wireframe each product 'card' with data about to inform ProductView methods **high priority**

## Deployment

- [x] Work out what the hierarchy of files should be and where to add my webpage files such that it functions correctly on Apache (**i.e:** `/var/www/src/html`?) *made web root from `/var/www/html` to `/var/www/src/html`*
- [x] Implement 'require' statement for autoloader on necessary files for server deployment (likely to be 'View' files) *just add at index root and route all pages through that file*
- ~~[ ] Integrate `twig` into the project's composer~~~*not required*
	- ~~[ ] Produce some html templates and construct page drafts using twig~~
- [x] Add `src/html` dir
- [ ] Parse `$_GET` parameters from URL and trim them off of the string in `src/html/index.php`
	- [ ] Write 'responder' class or file to parse $_POST or $_GET data and make appropriate actions (will be target of URL form)
- [ ] Make the content `src/html/views/index.php` and `src/html/views/add_product.php` AJAX-generated (Make `src/html/generated` directory with product generators)
    - [ ] Figure out how to program script supplying form inputs to `add_product.php` to detect what class properties to render *(php parameters to included file?)*

## Version Control

- [ ] - ~~Change 'Furniture_controller' branch to 'Furniture_presenter'~~ *Introduces unexpected PHPUnit changes and agony with git*
	- [ ] - ~~rename all relevant classes relating to 'controller'~~
		- [ ] - ~~**IMPORTANT** ensure that all PHPUnit tests still run~~
- [x] - Add `getFieldMap()` to `IProductController` interface
- [x] - pull all changes listed above over to `Furniture_view` and squash into previous cherry_pick commit - *Didn't squash*
