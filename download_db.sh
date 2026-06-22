#!/bin/bash

REMOTE_USER="nls"
REMOTE_HOST="103.172.204.6"
REMOTE_DIR="/www/wwwroot/tmc.kuydinas.id/keuangan_tmc"
LOCAL_FILE="database_dump.sql"

echo "🚀 Memulai proses download database dari server $REMOTE_HOST..."
echo "Langkah 1: Membuat dump database di server (Anda mungkin akan diminta memasukkan password SSH)."

ssh -t ${REMOTE_USER}@${REMOTE_HOST} "sudo su -c '
    cd ${REMOTE_DIR}
    # Ambil konfigurasi DB dari file .env
    DB_USER=\$(grep -E \"^DB_USERNAME=\" .env | cut -d \"=\" -f 2 | tr -d '\''\"'\'')
    DB_PASS=\$(grep -E \"^DB_PASSWORD=\" .env | cut -d \"=\" -f 2 | tr -d '\''\"'\'')
    DB_NAME=\$(grep -E \"^DB_DATABASE=\" .env | cut -d \"=\" -f 2 | tr -d '\''\"'\'')
    
    echo \"➡️ Mengekspor database: \$DB_NAME...\"
    if [ -z \"\$DB_PASS\" ]; then
        mysqldump -u\"\$DB_USER\" \"\$DB_NAME\" > /tmp/db_dump.sql
    else
        mysqldump -u\"\$DB_USER\" -p\"\$DB_PASS\" \"\$DB_NAME\" > /tmp/db_dump.sql
    fi
    
    echo \"➡️ Mengatur izin file untuk didownload...\"
    chmod 644 /tmp/db_dump.sql
    chown nls:nls /tmp/db_dump.sql
'"

echo "✅ Ekspor di server berhasil. Langkah 2: Mengunduh file ke komputer lokal..."
scp ${REMOTE_USER}@${REMOTE_HOST}:/tmp/db_dump.sql ${LOCAL_FILE}

echo "Langkah 3: Menghapus file dump sementara di server..."
ssh -t ${REMOTE_USER}@${REMOTE_HOST} "sudo rm /tmp/db_dump.sql"

echo "🎉 Selesai! Database berhasil didownload dan disimpan di folder proyek sebagai: ${LOCAL_FILE}"
