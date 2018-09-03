# Symfony_demo
- Create sample CRUD Symfony project
- List - Create - Detail - Update - Destroy Teacher and Student
- Using sqlite database
- Using migrate to create table and seed data.
- Using Doctrine ORM.
- Using twig template.

#Set up

- Clone code frome github

- Run composer to download lib: composer install

- Run create database: php bin/console doctrine:database:create

- Run Creating the Database Tables/Schema: php bin/console doctrine:migrations:migrate

- Run server : php bin/console server:run.
