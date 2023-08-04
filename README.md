## Laravel Installation

### 1. Install Composer Dependencies

```php
composer install
```

### 2. Install NPM Dependencies
Npm install Dependencies

```php
composer install
```

Or yarn

```php
Yarn
```

### 3. Create a copy of .env file

```php
cp .env.example .env
```

### 4. Generate an app encryption key 

```php
php artisan key:generate
```

### 5. Create an empty database for our application

Create an empty database for your project using the database tools you prefer. In our example we created a database called “test”. Just create an empty database here, the exact steps will depend on your system setup.

### 6. In the .env file, add database information to allow Laravel to connect to the database

In the .env file fill in the DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.


### 7. Migrate the database and seed the database

Once your credentials are in the .env file, now you can migrate your database and seed the database.

```php
php artisan migrate --seed
```

### 8. Vite build the assets

```php
vite build
```

Or

```php
Nom run build
```

### 9. Serve the website

You can run php artisan serve to serve your website in localhost

```php
php artisan serve
```

Or


```php
vagrant up
```

```php
valet park
```

You can use <a href="https://laravel.com/docs/10.x/homestead">Homestead </a> or <a href="https://laravel.com/docs/10.x/valet"> Valet </a> (Mac) to serve the website.



### 10. Login and test the website [Optional]

<table>
<tr>
<th>Name</th>
<th>Password</th>
</tr>

<tr>
<td>test1@example.com</td>
<td>password</td>
</tr>

</table>

### 11. Test api endpoint by postman

You can find Accredify assessment postman collection file in project root folder. Import 'Accredify Assessment.postman_collection.json' to postman and view the api full document.

Please change base_url before use postman to test api. You can login with account provided above to test the api.
