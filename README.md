# Task Manager

## Развертываение проекта локально
> Добавить env файл
```
cp .env-example .env
```
> Установить зависимости
```
composer install
```
> Применить миграции
```
php bin/console doctrine:migration:migrate
```