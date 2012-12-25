Singly PHP Example
===================
A bare bones example of using the Singly PHP library

To use this branch run ``` git branch -f example origin/example ``` then ``` git checkout example ```

Install
=======
1. install composer via ``` curl -s http://getcomposer.org/installer | php ``` (on windows, download http://getcomposer.org/installer and execute it with PHP)

2. run ``` php composer.phar install ```

3. edit index.php and add your Singly Client ID and Client Secret

4. run ``` php -S localhost:8082 ``` and browse to ``` http://localhost:8082/index.php ```

5. you will be redirected to facebook login and after logging in

6. you will be shown your facebook feed as a raw object print_r.
