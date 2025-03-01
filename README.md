![alt text](/public/img/image.png)

## Установка проекта

Следуйте этим шагам, чтобы настроить и запустить проект локально.

### Требования
- PHP
- Composer
- Токен доступа к API от [TMDb](https://www.themoviedb.org/documentation/api) (API Read Access Token (v4 auth))

### Шаги установки:

```bash
git clone https://github.com/iammaga/Netflix.git
cd Netflix
```
```bash
composer install
```
```bash
cp .env.example .env
```
Откройте файл .env и добавьте ваш API-токен TMDb, заменив <TMDB_TOKEN> на ваш токен:
```bash
TMDB_TOKEN=<TMDB_TOKEN>
```
```bash
php artisan key:generate
```
```bash
php artisan serve
```
В веб-браузере перейдите по адресу: http://localhost:8000.

### Идеа
```bash
https://roadmap.sh/projects/movie-reservation-system
https://roadmap.sh/projects/tmdb-cli
```
