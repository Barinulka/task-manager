# Развертываение проекта локально
> Добавить env файл
```
cp .env-example .env
```
> Установить зависимости
```
composer install
```
> Сгенерировать ключи для JWT авторизации
```
php bin/console lexik:jwt:generate-keypair
```
> Запустить локальную БД
```
docker-compose up -d
или
docker compose up -d
```
> Запустить symfony сервер
```
symfony server:start
symfony server:start -d
```
> Применить миграции
```
php bin/console doctrine:migration:migrate
```
[`Назад`](../README.md)