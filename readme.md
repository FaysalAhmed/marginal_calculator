# Mergin Calculator 
## Problem Statement 
The task is to create a margin calculator which would calculate the accumulated total profit from the given sequences of purchases and sales.  

The calculator has to accept the input purchases and sales one at a time. For that purpose there should be to actions – buy and sell, each consisting of two inputs – quantity (integer) and price (a plain number without the currency designation). The sequence of  buy and sell actions can be of any length and given in any order.  

Finally, there has to be an action to the get the total profit. It does not take any input and returns a single number – the total profit generated by the sequence of buy/sell actions entered up to this moment.  

In order to demonstrate your skills in specific areas we ask you to provide the solution using the latest version of Symfony framework using Doctrine ORM and MySQL database. The user interface should be a minimal web page that uses Boostrap for basic styling and the html content should be rendered using Twig template engine. Dependencies should be managed using Composer.

## About the solution 

To solve the problem given above I have developed this web based solution which will maintain an inventory for a single item type and maintain sells and marginal profit according to the given equation.
### Technologies used 
- Symfony 5.0.7
- Mysql 8.0.19 
- composer 1.9.3 
- Bootstrap 4.4.1 via CDN 
 
### System Requirement 
- Symfony and composer installed in system 
- mysql database version 8 recommended but should work on any mysql or mariaDB.
- 1 vCPU and 1GB ram recommended
- As we are using CDN, internet connection is required 

## How to run 

- make sure Symfony, mysql and all dependencies are installed. (e.g: composer install)
- make sure the database is created in mysql and mysql connection string is set in .env file and .env.test file for running test codes. (better to have a separate database for the test.)- run
``php bin/console doctrine:migration:migrate
 ``
 to migrate the database
 - run  `` symfony serve`` and open http://localhost:8000 to view application 
 
 ## How to use 
 
 - in the top menu, use Buy New Items to insert items in inventory. You can also check the Inventory List to check current inventory status. 
 - Similarly, you can use Sell Items to sell items. The profit per item will be calculated automatically.  
 - Also the total profit will be calculated and will show on the front page 
 - You can use reset to remove all data from database so that you can make fresh calculation 
 
 
 ##Future Improvements
 
 - A good dashboard 
 - a front end framework (e.g: React or Vue)
 - Deployment to Heroku 
 
  

