# Rest-APi-Token-helper-class-for-authentication-for-laravel
Before using this class, you need  to run
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
and initialize this with your secretkey

place the files in the required directories

