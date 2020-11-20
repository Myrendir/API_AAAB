# API_AAAB

This project is API REST for the website management tournament league of legends

## Party Developer

### Recover the project

#### First Step
```
git clone git@github.com:Myrendir/API_AAAB.git
```
After, create the file .env.local, and paste the content of the file .env. Change the DATABASE_URL with your id for connect at the db

### Second Step
Run this command : 
```
composer install
```

### Third Step
Run this command
```
./bin/console doctrine:schema:update --force
./bin/console doctrine:fixtures:load
```

#### Four Step
Generate the jwt, run this command:
```
* mkdir -p config/jwt
* openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
* openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

For start the application, run this command
```
php -S localhost:8000 -t public
```

The project is already for the development

For run the tests, run this command :
```
./vendor/bin/codecept run functional
./vendor/bin/codecept run unit
```

