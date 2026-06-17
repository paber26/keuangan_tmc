#!/bin/bash

echo "🚀 Menghubungkan ke server 103.172.204.6 untuk proses Deployment..."
echo "Mohon masukkan password SSH Anda jika diminta..."

ssh -t nls@103.172.204.6 "sudo su -c '
echo \"✅ Berhasil masuk sebagai root!\"

# Masuk ke folder project
cd /www/wwwroot/tmc.kuydinas.id/keuangan_tmc

echo \"➡️ Menarik pembaruan dari Git (git pull)...\"
git pull origin main

echo \"➡️ Menjalankan migrasi database (php artisan migrate)...\"
php artisan migrate --force

echo \"➡️ Menjalankan seeding data awal (Karyawan & Kebun)...\"
php artisan db:seed --class=KaryawanSeeder --force
php artisan db:seed --class=KebunSeeder --force

echo \"➡️ Memperbarui izin akses file (Permissions)...\"
chown -R www:www storage bootstrap/cache

echo \"🎉 Deployment selesai! Pembaruan sistem sudah live di tmc.kuydinas.id\"
'"
