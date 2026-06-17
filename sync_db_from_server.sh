#!/bin/bash

echo "🚀 Menghubungkan ke server 103.172.204.6 untuk mengambil Database..."
echo "Mohon masukkan password SSH Anda (nls) jika diminta (Mungkin akan diminta 2 kali)..."

ssh -t nls@103.172.204.6 "sudo su -c '
cd /www/wwwroot/tmc.kuydinas.id/keuangan_tmc
# Baca konfigurasi database dari .env
DB_NAME=\$(grep DB_DATABASE .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")
DB_USER=\$(grep DB_USERNAME .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")
DB_PASS=\$(grep DB_PASSWORD .env | cut -d \"=\" -f2 | tr -d \"\\r\\n\")

echo \"➡️ Membuat backup dari database server (\$DB_NAME)...\"
mysqldump -u \$DB_USER -p\$DB_PASS \$DB_NAME > public/db_dump_temp_123.sql
chmod 644 public/db_dump_temp_123.sql
echo \"✅ Backup sementara berhasil dibuat di server.\"
'"

echo "⬇️ Mengunduh file database dari server ke komputer lokal..."
curl -s -o local_backup.sql https://tmc.kuydinas.id/db_dump_temp_123.sql

echo "🗑️ Menghapus file backup di server (demi keamanan)..."
ssh -t nls@103.172.204.6 "sudo su -c 'rm /www/wwwroot/tmc.kuydinas.id/keuangan_tmc/public/db_dump_temp_123.sql'"

if [ -f "local_backup.sql" ]; then
    echo "➡️ Mengosongkan database lokal dan mengimpor data baru..."
    
    php -r "
        require 'vendor/autoload.php';
        \$app = require_once 'bootstrap/app.php';
        \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
        
        // Disable foreign key checks temporarily and wipe
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \$tables = DB::select('SHOW TABLES');
        foreach (\$tables as \$table) {
            \$tableName = array_values((array)\$table)[0];
            DB::statement('DROP TABLE IF EXISTS ' . \$tableName);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // Import new sql
        echo \"Mengimpor baris data...\\n\";
        DB::unprepared(file_get_contents('local_backup.sql'));
        echo \"✅ Database lokal berhasil di-sync dengan server!\\n\";
    "

    echo "🧹 Membersihkan file sementara..."
    rm local_backup.sql
    echo "🎉 PROSES SELESAI! Data server sudah berhasil disalin ke lokal Anda."
else
    echo "❌ Gagal mengunduh file backup dari server."
fi
