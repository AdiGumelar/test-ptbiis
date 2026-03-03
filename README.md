## SETUP PERTAMA KALI

1. composer install
2. copy .env.example .env
3. php artisan key:generate
4. php artisan migrate
5. php artisan storage:link
6. php artisan serve

`Sebelum run website, jalankan seeder (php artisan db:seed)`

`Untuk database ada dua tabel yaitu positions dan employees yang berelasi one to many`

## API

`GET /api/employees -> AMBIL SEMUA DATA`

`GET /api/employees/{id} -> AMBIL DATA PADA ID TERTENTU`

`PUT /api/employees/{id} -> EDIT DATA PADA ID TERTENTU`

`DELETE /api/employees/{id} -> HAPUS DATA PADA ID TERTENTU`

`POST /api/employees -> KIRIM DATA`
