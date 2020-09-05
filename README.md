### WhiteRabbit Code Test

Steps to setup the project

To run the API

1. $ cd /path/to/www/
2. $ git clone https://github.com/rafeequekhp134/WightRabbitTest WRCodeTest
3. Create a MySQL database with the name 'wrcodetest'.
4. Edit the .env file if you have any change in database host, username or password.
5. $ cd WRCodeTest
6. $ composer update
7. $ php artisan migrate
8. $ php artisan serve

To run the UI

1. Open to another terminal window in the project root
2. $ npm run watch
3. Then go to the link http://127.0.0.1:8000 in your browser.
4. Register the user and login to get into the dashboard
