# Product Catalogue WebApp

## A simple webapp to catalogue products of different categories and their subsequent attributes

### Development languages:

* PHP
* JavaScript
* MySQL

This project is in reponse to a 'Junior Developer Entry test' assignment from a prospective employer and constitutues (in a functional state) a deliverable to this assignment

## Setup instructions
### Requisites:
 - docker
 - a broswer

## Installation instructions

 1. Open terminal
 2. run `git clone https://srmes@bitbucket.org/srmes/shopping_app_test.git`
 3. run `cd shopping_app_test`
 4. run `docker-compose build`
 5. run `docker-compose up`
 6. run `docker ps` and copy the 'container_id' for the entry with an 'IMAGE' field of 'test:shopping'
 7. run `docker exec -it [container_id] bash -l
 8. [inside of the container] run `cd .. && vendor/bin/doctrine orm:schema-tool:create. Ensure the output says 'Database schema created successfully!'

## Inspection instructions

Afer completing the above installation instructions

 1. Open a modern web browser
 2. Navigate to localhost:8000 (homepage/view all products)
 3. Navigate to localhost:8000/add_product (input form to add a new product)

**Finally** enjoy!
