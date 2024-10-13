# Tugas Besar IF3110 2024/2025

Cara jalanin 

```
COPY .env.example ke .env
lalu
docker compose up
```
Kalau baru run pertama kali, migrations dulu
```
docker exec -it php-apache php  setup/run_migrations.php
```
buka webnya di localhost:8000

Kalau mau jalanin di lokal tanpa docker (harus install php sama postgre dulu)
```
php -S localhost:8000 -t app
```

