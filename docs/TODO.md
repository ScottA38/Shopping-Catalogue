#Outstanding development tasks

## Security

- [ ] Put all database connection parameters in a secret file deeper in the server file hierarchy
	- [ ] Ensure that all views which require the database connection parameters can read the hidden file in order to connect to the database

## Views

- [x] Research into/decide whether the view can be polymorphic (supports display of objects regardless of type)
~~- [ ] Implement tests~~~ - will not be tested as it is UI
- [x] Implement `ProductView` view base class

## Webpages

- [x] Wireframe each product 'card' with data about to inform ProductView methods **high priority**

## Deployment

- [ ] Work out what the hierarchy of files should be and where to add my webpage files such that it functions correctly on Apache (**i.e:** `/var/www/src/html`?)
- [ ] Implement 'require' statement for autoloader on necessary files for server deployment (likely to be 'View' files)
- [ ] Integrate `twig` into the project's composer
	- [ ] Add `src/html` dir
		- [ ] Produce some html templates and construct page drafts using twig

## Version Control

- [ ] - ~~Change 'Furniture_controller' branch to 'Furniture_presenter'~~ *Introduces unexpected PHPUnit changes and agony with git*
	- [ ] - ~~rename all relevant classes relating to 'controller'~~
		- [ ] - ~~**IMPORTANT** ensure that all PHPUnit tests still run~~
- [x] - Add `getFieldMap()` to `IProductController` interface
- [x] - pull all changes listed above over to `Furniture_view` and squash into previous cherry_pick commit - *Didn't squash*
