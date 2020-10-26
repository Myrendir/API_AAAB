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
```

#### Four Step
Create the database :
```
./bin/console doctrine:schema:update --force
```

#### Load Fixtures
Run this command :
```
./bin/console doctrine:datafixtures:load
```

The project is already for the development

