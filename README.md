# API_AAAB

This project is API REST for the website management tournament league of legends

## Party Developer

### Recover the project

#### First Step
```
git clone git@github.com:Myrendir/API_AAAB.git
```

#### Second Step
Create the file .env.local and update the variable DATABASE_URL

#### Third Step
Run this command : 
```
composer install
./bin/console assets:install
./bin/console doctrine:database:create
./bin/console doctrine:schema:update --force
```