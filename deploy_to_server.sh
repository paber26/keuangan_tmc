#!/bin/bash

echo "🚀 Menghubungkan ke server 103.172.204.6..."
echo "Mohon masukkan password SSH Anda jika diminta..."

ssh -t nls@103.172.204.6 "sudo su -c '
echo \"✅ Berhasil masuk sebagai root!\"

echo \"➡️ Memperbaiki Nginx 404 Not Found (URL Rewrite Laravel)...\"

# Mengisi file URL Rewrite bawaan aaPanel khusus untuk domain ini
REWRITE_CONF=\"/www/server/panel/vhost/rewrite/tmc.kuydinas.id.conf\"

cat << EOF > \"\$REWRITE_CONF\"
location / {
    try_files \\\$uri \\\$uri/ /index.php?\\\$query_string;
}
EOF

echo \"✅ File rewrite Nginx berhasil diperbarui!\"

echo \"➡️ Restart Nginx agar perubahan langsung aktif...\"
systemctl restart nginx || /etc/init.d/nginx restart

echo \"🎉 Setting Routing Laravel selesai! Silakan refresh menu /kebun Anda sekarang.\"
'"
