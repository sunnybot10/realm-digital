# Realm Digital Interview Assessment - Address Book


Clone this project using the following commands:

```
git clone https://github.com/sunnybot10/realm-digital
cd realm-digital
```

### Set up the Backend

Create the database and user for the project:

```
mysql -u root -p
CREATE DATABASE realm-digital CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL on realm-digital.* to realm-digital@127.0.0.1 identified by 'realm-digital';
quit
```

Copy the example `.env` file:

```
cd realm-digital
cp .env.example .env
```

Put the database details in the `.env` file:

```
DB_DATABASE=realm-digital
DB_USERNAME=realm-digital
DB_PASSWORD=realm-digital
```


Install the project dependencies, generate a project key, run the migrations and then start the server:

```
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

Loading [127.0.0.1:8000] now should show the default Laravel login, and [127.0.0.1:8000/register] should show you want to create a user for authorization. 

NOTE: if using a virtual machine and NAT, you might need to run the server as `php artisan serve --host 0.0.0.0` instead.

### Set up the Frontend

```
cd realm-digital
npm install
npm run watch
```
