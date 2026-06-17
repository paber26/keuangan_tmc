#!/bin/bash

echo "🚀 Menghubungkan ke server untuk memperbarui konfigurasi Database (.env)..."
echo "Mohon masukkan password SSH Anda (nls) jika diminta..."

ssh -t nls@103.172.204.6 "sudo su -c '
cd /www/wwwroot/tmc.kuydinas.id/keuangan_tmc

# Menghapus konfigurasi SQLite dan mengaktifkan MySQL
sed -i \"s/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/g\" .env
sed -i \"s/# DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/g\" .env
sed -i \"s/# DB_PORT=3306/DB_PORT=3306/g\" .env
sed -i \"s/# DB_DATABASE=laravel/DB_DATABASE=db_keuangan_tmc/g\" .env
sed -i \"s/# DB_USERNAME=root/DB_USERNAME=db_keuangan_tmc/g\" .env
sed -i \"s/# DB_PASSWORD=/DB_PASSWORD=i3HXijTMZKzjHPy7/g\" .env

echo \"✅ File .env di server berhasil diperbarui ke MySQL!\"

# Membersihkan cache konfigurasi Laravel
php artisan config:clear
'"
