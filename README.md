wydatki
===
A simple PHP/Symfony application to manage personal finances.

Installation
---
```
git clone https://github.com/dominiol/wydatki.git
cd wydatki
composer install
```
After installing composer dependencies, you have to modify `.env` file: append information about your MySQL database and main password's MD5 hash. For example, the most important lines should look like this:
```
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
PASSWORD_MD5_HASH=098f6bcd4621d373cade4e832627b4f6
```
In this example `098f6bcd4621d373cade4e832627b4f6` equals to `md5("test")`. You can also specify an environment (production or development):
```$xslt
#APP_ENV=dev
APP_ENV=prod
```

After modyfing the `.env` file, you have to create database schema using command:
```$xslt
php bin/console doctrine:schema:create
```

Now, you can run *wydatki* by pointing your web server to directory `/public`.

License
---
MIT