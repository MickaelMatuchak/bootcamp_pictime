## PiCraft

### Deploiement

- composer update

Créer une base de donnée et importer 'bootcamp.sql' à configurer dans class/Pdo.php

- php -S 127.0.0.1:8080 -t public

### Test

Créer une base de donnée test et importer 'bootcamp.sql' à configurer dans tests/BDD/ConnexionTest.php

- ./vendor/bin/phpunit tests
