### WhiteRabbit Code Test

Steps to setup the project

To run the API

1. $ cd /path/to/www/
2. $ git clone https://github.com/rafeequekhp134/DonaTest.git
3. Create a MySQL database with the name 'donatest'.
4. Copy the .env.example to .env and edit the configs if you have any change in database host, username or password.
5. $ cd DonaTest
6. $ composer install
7. $ npm install
8. $ php artisan key:generate
9. $ php artisan jwt:secret
10. $ php artisan migrate
11. $ php artisan db:seed
12. $ php artisan serve

To run the UI

1. Open to another terminal window in the project root
2. $ npm run watch
3. Then go to the link http://127.0.0.1:8000 in your browser.
4. Register the user and login to get into the dashboard
