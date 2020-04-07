**a list of suggested entities for the shopping_webapp MVC structure**

## ./src/Models/
	* Product
        * Properties:
            * SKU
            * Name
            * Price
	* Furniture: extends 'Product'
        * Properties:
            * (Product props)
            * Dimensions
	* Book: extends 'Product'
	* DVD-disc: extends 'Product'

## ./src/Views/
	* Add product view
	* Show all products view

## ./src/Controllers/
	* Furniture Controller
    * Book Controller
    * DVD-Disc Controller
