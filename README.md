# API_AAAB

This project is API REST for the website management tournament league of legends

## WARNING
In the file hosts, add the follow lines :
```
127.0.0.1	admin.api-aaab.com
127.0.0.1	api-aaab.com
127.0.0.1   db.api-aaab.com
127.0.0.1	mail.api-aaab.com
```
* For linux, the file is located in /etc/hosts
* For Windows, the file is located in C:\Windows\System32\drivers\etc\hosts

## Party Developer

### Recover the project

#### First Step
```
git clone git@github.com:Myrendir/API_AAAB.git
```

#### Second Step
Create the file .env.local and update the variable DATABASE_URL
Create the docker.env and add this variable:
```
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=
MYSQL_USER=
MYSQL_PASSWORD=
```
!! This variables, she is same in the .env.local for DATABASE_URL except MYSQL_ROOT_PASSWORD

#### Third Step
Run this command : 
```
cd docker/nginx-proxy/
docker network create nginx-proxy
docker-compose up -d
cd ..
cd ..
docker-compose build
docker-compose up -d
sudo chown -R userlocal:userlocal vendor var
```

The project is already for the development

## Party for functional now

### Recover the project

#### First Step
```
git clone git@github.com:Myrendir/API_AAAB.git
```

#### Second Step
Create the file .env.local and update the variable DATABASE_URL
Create the docker.env and add this variable:
```
MYSQL_ROOT_PASSWORD=
MYSQL_DATABASE=
MYSQL_USER=
MYSQL_PASSWORD=
```
!! This variables, she is same in the .env.local for DATABASE_URL except MYSQL_ROOT_PASSWORD

#### Third Step
Run this command : 
```
cd docker/nginx-proxy/
docker network create nginx-proxy
docker-compose up -d
cd ..
cd ..
docker-compose build
docker-compose up -d
```

The project is already