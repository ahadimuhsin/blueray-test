# Instalasi

## Requirement
Pastikan spesifikasi sistem memenuhi hal berikut:
- **PHP:** versi  >= 8.2
- **Composer:**  versi >= 2.0
- **Database:** MySQL 8.0+
- **Web Server:** Apache or Nginx

Bisa menggunakan XAMPP atau Laragon versi PHP terbaru supaya lebih mudah

## Langkah-langkah

1. **Clone the Repository**

   Clone repository ini:

   ```bash
   git clone https://github.com/ahadimuhsin/blueray-test.git
   ```

   Masuk ke dalam folder:

   ```bash
   cd blueray_test
   ```

2. **Install Dependencies**

   Jalankan composer:

   ```bash
   composer install
   ```

3. **Set Up Environment File**

   Copy file .env.example ke dalam file .env

   ```bash
   cp .env.example .env
   ```

  Buka file .env kemudian atur pengaturan database

4. **Generate Application Key**

   Generate the application key to secure your application:

   ```bash
   php artisan key:generate
   ```
5. **Setting Biteship API**
Dapatkan API KEY Biteship di link ini [Biteship API](https://biteship.com/en/docs/api/usage_flow "Biteship API")
Setelah itu, tambahkan key BITESHIP_URL dan BITESHIP_API_KEY ke file .env
```
BITESHIP_URL=https://api.biteship.com
BITESHIP_API_KEY=KEY_HERE
```

6. **Run Database Migrations**

   Jalankan database migrations beserta seeder

   ```bash
   php artisan migrate --seed
   ```
Perintah ini akan menambahkan dua data ke tabel users

  Sebagai admin
```
admin1@mail.com
Password123#
```
  Sebagai user
```
user1@mail.com
Password123#
```

##Dokumentasi
Dokumentasi endpoint dapat dilihat di link [ini](https://documenter.getpostman.com/view/10026548/2sAYQgg8Ti "ini")
