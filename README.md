# Rest-APi-Token-helper-class-for-authentication-for-laravel
this class requires you to run
```
composer require firebase/php-jwt

```
in cofig directory create the Token file and paste that code
```
<?php
return[
    'Api_Token' =>[
        'Key'=>env('REST_API_TOKEN',"somekeys")
    ]
]
    ?>
    ```

in your .env add 
```
REST_API_TOKEN 
```
and initialize t to your secretkey

Make Facade of class and enjoy !!!

