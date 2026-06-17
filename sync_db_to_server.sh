#!/bin/bash

echo "🚀 Memulai proses sinkronisasi database (Lokal ➡️ Server)..."

echo "1️⃣ Mengekspor data dari komputer lokal..."
# Dapatkan nama user dan database dari .env
LOCAL_DB_USER=$(grep DB_USERNAME .env | cut -d '=' -f2 | tr -d '\r\n')
LOCAL_DB_NAME=$(grep DB_DATABASE .env | cut -d '=' -f2 | tr -d '\r\n')
LOCAL_DB_PASS=$(grep DB_PASSWORD .env | cut -d '=' -f2 | tr -d '\r\n')

# Ekspor database menggunakan PHP artisan tinker agar tidak butuh mysqldump jika tidak tersedia
php -r "
    require 'vendor/autoload.php';
    \$app = require_once 'bootstrap/app.php';
    \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // We use a simple system call to mysqldump. If it fails, fallback to user instruction.
    \$user = env('DB_USERNAME');
    \$pass = env('DB_PASSWORD') ? '-p' . env('DB_PASSWORD') : '';
    \$db = env('DB_DATABASE');
    
    // Find mysqldump path since it might not be in the default PATH
    \$mysqldumpPath = 'mysqldump'; // default
    if (file_exists('/opt/homebrew/bin/mysqldump')) {
        \$mysqldumpPath = '/opt/homebrew/bin/mysqldump';
    } elseif (file_exists('/usr/local/bin/mysqldump')) {
        \$mysqldumpPath = '/usr/local/bin/mysqldump';
    } elseif (file_exists('/Applications/MAMP/Library/bin/mysqldump')) {
        \$mysqldumpPath = '/Applications/MAMP/Library/bin/mysqldump';
    }
    
    // Check if mysqldump exists
    \$output = null;
    \$result = null;
    exec(\"{\$mysqldumpPath} -h 127.0.0.1 -P 3306 -u \$user \$pass \$db > local_dump.sql 2>&1\", \$output, \$result);
    
    if (\$result !== 0) {
        echo \"\\n❌ Gagal melakukan ekspor lokal. Mohon pastikan aplikasi MySQL/mysqldump terinstall di komputer Anda.\\n\";
        echo \"Detail Error: \" . implode(\"\\n\", \$output) . \"\\n\";
        exit(1);
    }
" || exit 1

echo "✅ Ekspor lokal berhasil (local_dump.sql)"

echo "2️⃣ Mengunggah data ke server..."
echo "Mohon masukkan password SSH Anda (nls) jika diminta (Bisa diminta 2 kali)..."
scp local_dump.sql nls@103.172.204.6:/tmp/local_dump.sql

echo "3️⃣ Menerapkan data ke database Server..."
ssh -t nls@103.172.204.6 "sudo su -c '
cd /www/wwwroot/tmc.kuydinas.id/keuangan_tmc
DB_NAME=\$(grep DB_DATABASE .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")
DB_USER=\$(grep DB_USERNAME .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")
DB_PASS=\$(grep DB_PASSWORD .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")

echo \"➡️ Menimpa data di server (\$DB_NAME)...\"
mysql -u \$DB_USER -p\$DB_PASS \$DB_NAME < /tmp/local_dump.sql
rm /tmp/local_dump.sql
echo \"✅ Impor di server berhasil!\"
'"

echo "🧹 Membersihkan file sementara..."
rm local_dump.sql

echo "🎉 PROSES SELESAI! Data absensi dan pengaturan lokal Anda sudah aktif di server tmc.kuydinas.id!"
