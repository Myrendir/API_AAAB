# API_AAAB

This project is API REST for the website management tournament league of legends

## Party Developer

### Recover the project

#### First Step
```
git clone git@github.com:Myrendir/API_AAAB.git
```

#### Second Step
* Create the file .env.local and update the variable DATABASE_URL
* Create the file docker.env, and add the variables, the values are same who correspond at DATABASE_URL :
```
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=
MYSQL_USER=
MYSQL_PASSWORD=
```

#### Third Step
Run this command : 
```
composer install
```

#### Four Step
Generate the jwt, run this command:
```
* mkdir -p config/jwt
* openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
* openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
* sudo chmod -R 777 config/jwt
```

#### Five Step
Start Docker with this command:
```
* cd docker/nginx-proxy
* docker network create nginx-proxy
* docker-compose up -d
* cd ../..
* docker-compose build
* docker-compose up -d
```

#### Six Step
In your file hosts, which is in the folder /etc/hosts for linux and for windows which is C:\Windows\System32\drivers\etc, add the test follow:
```
# APi AAAB
127.0.0.1	admin.api-aaab.com
127.0.0.1	api-aaab.com
127.0.0.1   	db.api-aaab.com
127.0.0.1	mail.api-aaab.com
# API AAAB
```

The project is already for the development

