# Sistem Pencatatan Keuangan Perkebunan — Laravel Fullstack

Sistem pencatatan keuangan pribadi untuk supervisor perkebunan. Mencakup pencatatan hasil panen, absensi & hasil kerja harian, penggajian (bulanan, harian, borongan kupas kelapa), upload foto bukti kerja, rekap mingguan, serta export laporan ke Word & PDF untuk manajer.

> [!NOTE]
> **Single user** — Supervisor login via email & password. Tanpa multi-role.
> Default login: `admin@kebun.com` / `password`

## Arsitektur Sistem

```mermaid
graph TB
    subgraph "Frontend - Blade + Livewire"
        LOGIN[🔐 Login]
        A[Dashboard<br/>Ringkasan Keuangan]
        B[Master Data<br/>Kebun, Karyawan, Komoditas, Tarif]
        C[Pencatatan Harian<br/>Absen, Hasil Kerja, Panen, Foto]
        D[Penggajian<br/>Bulanan / Harian / Borongan]
        E[Rekap & Laporan<br/>Mingguan, Bulanan, Export]
    end

    subgraph "Backend - Laravel 11"
        F[Controllers] --> G[Services]
        G --> H[Eloquent Models]
    end

    subgraph "Storage"
        I[(MySQL - 13 Tabel)]
        J[📁 Storage<br/>Foto Bukti Kerja]
    end

    LOGIN --> A
    A & B & C & D & E --> F
    H --> I
    F --> J
```

## Entity Relationship Diagram

```mermaid
erDiagram
    USER ||--o{ KEBUN : manages

    KEBUN ||--o{ BLOK : has
    KEBUN ||--o{ PANEN : produces
    KEBUN ||--o{ TRANSAKSI : has

    KARYAWAN ||--o{ ABSENSI : has
    KARYAWAN ||--o{ GAJI_BULANAN : receives
    KARYAWAN ||--o{ UPAH_HARIAN : receives
    KARYAWAN ||--o{ UPAH_BORONGAN : receives

    KOMODITAS ||--o{ PANEN : categorized
    KOMODITAS ||--o{ TARIF_KUPAS : has_rates

    ABSENSI ||--o{ UPAH_HARIAN : linked
    ABSENSI ||--o{ UPAH_BORONGAN : linked

    UPAH_HARIAN ||--o{ FOTO_BUKTI : has_photos
    UPAH_BORONGAN ||--o{ FOTO_BUKTI : has_photos
    PANEN ||--o{ FOTO_BUKTI : has_photos

    USER {
        bigint id PK
        string name
        string email
        string password
    }

    KEBUN {
        bigint id PK
        string nama
        string lokasi
        decimal luas_hektar
        text keterangan
        boolean aktif
    }

    BLOK {
        bigint id PK
        bigint kebun_id FK
        string nama_blok
        decimal luas_hektar
        int jumlah_pohon
    }

    KOMODITAS {
        bigint id PK
        string nama "Kelapa Butiran, Kopra"
        string satuan "butir, kg"
        decimal harga_jual
    }

    KARYAWAN {
        bigint id PK
        string nama
        string no_hp
        enum tipe "tetap, harian, borongan"
        bigint kebun_id FK
        decimal gaji_pokok "khusus tipe tetap"
        decimal upah_harian "khusus tipe harian"
        date tanggal_masuk
        boolean aktif
    }

    TARIF_KUPAS {
        bigint id PK
        bigint komoditas_id FK
        string jenis "kupas sabut, kupas batok"
        decimal tarif_per_satuan
        string satuan "butir, kg"
        boolean aktif
    }

    ABSENSI {
        bigint id PK
        bigint karyawan_id FK
        bigint kebun_id FK
        date tanggal
        enum status "hadir, izin, sakit, alpha"
        time jam_masuk
        time jam_keluar
        text catatan
    }

    PANEN {
        bigint id PK
        bigint kebun_id FK
        bigint blok_id FK
        bigint komoditas_id FK
        date tanggal
        decimal jumlah
        decimal harga_satuan
        decimal total_nilai
        text catatan
    }

    GAJI_BULANAN {
        bigint id PK
        bigint karyawan_id FK
        bigint kebun_id FK
        int bulan
        int tahun
        int total_hadir
        int total_izin
        int total_sakit
        int total_alpha
        decimal gaji_pokok
        decimal tunjangan
        decimal potongan
        decimal total
        date tanggal_bayar
        boolean sudah_bayar
    }

    UPAH_HARIAN {
        bigint id PK
        bigint karyawan_id FK
        bigint kebun_id FK
        bigint absensi_id FK
        date tanggal
        decimal upah
        text pekerjaan
        boolean sudah_bayar
    }

    UPAH_BORONGAN {
        bigint id PK
        bigint karyawan_id FK
        bigint kebun_id FK
        bigint absensi_id FK
        bigint tarif_kupas_id FK
        date tanggal
        decimal jumlah_satuan
        decimal tarif
        decimal total_upah
        text catatan
        boolean sudah_bayar
    }

    FOTO_BUKTI {
        bigint id PK
        string model_type "panen, upah_harian, upah_borongan"
        bigint model_id
        string file_path
        string caption
        timestamp uploaded_at
    }

    TRANSAKSI {
        bigint id PK
        bigint kebun_id FK
        enum tipe "masuk, keluar"
        string kategori "penjualan, gaji, upah_harian, upah_borongan, operasional"
        decimal jumlah
        date tanggal
        text keterangan
    }
```

## Modul & Fitur

### 0. 🔐 Login
- Halaman login sederhana: email + password
- Default user: `admin@kebun.com` / `password`
- Session-based authentication (Laravel Breeze)
- Redirect ke dashboard setelah login

### 1. 🏠 Dashboard
- Total pemasukan & pengeluaran bulan ini
- Saldo per kebun
- Grafik tren panen 6 bulan terakhir
- Upah/gaji yang belum dibayar
- Ringkasan minggu ini (absen, hasil kupas, panen)

### 2. 📋 Master Data

| Menu | Keterangan |
|------|------------|
| **Kebun** | Nama, lokasi, luas. Tiap kebun bisa punya blok |
| **Karyawan** | Nama, tipe (tetap/harian/borongan), kebun, gaji pokok / upah harian |
| **Komoditas** | Jenis hasil (kelapa butiran, kopra, dll), satuan, harga jual |
| **Tarif Kupas** | Tarif per satuan kupas kelapa per jenis pekerjaan |

### 3. 📝 Pencatatan Harian

#### a) Absensi
- Input kehadiran harian per karyawan per kebun
- Status: hadir, izin, sakit, alpha
- Jam masuk & jam keluar (opsional)
- Data absensi menjadi **dasar perhitungan gaji**

#### b) Hasil Kerja Harian + Foto
- Input hasil kupas kelapa (borongan) per pekerja
- Input upah harian per pekerja
- **Upload foto bukti kerja** (foto dari WhatsApp bisa di-upload di sini)
- Setiap pencatatan bisa punya **banyak foto**

#### c) Pencatatan Panen
- Input hasil panen per kebun per blok
- Upload foto hasil panen
- Otomatis catat transaksi masuk

### 4. 💰 Penggajian

#### a) Gaji Bulanan — Karyawan Tetap
- Generate otomatis berdasarkan **data absensi bulan tersebut**
- Tampilkan: total hadir, izin, sakit, alpha
- Hitung: gaji pokok + tunjangan - potongan (berdasarkan absen)
- Tandai sudah bayar → catat transaksi keluar

#### b) Upah Harian — Pekerja Harian
- Dihitung dari absensi harian × tarif harian
- **Rekap mingguan**: total hari kerja × upah per hari
- Rekap bulanan
- Tandai sudah bayar per minggu/bulan

#### c) Upah Borongan — Kupas Kelapa Per Satuan
- Dihitung dari hasil kerja harian × tarif per satuan
- **Rekap mingguan**: total satuan × tarif
- Rekap bulanan
- Tandai sudah bayar per minggu/bulan

### 5. 📊 Rekap & Laporan

| Laporan | Detail |
|---------|--------|
| **Rekap Mingguan** | Rangkuman absen, hasil kerja, upah per minggu per kebun |
| **Rekap Bulanan** | Total panen, total gaji/upah, laba rugi per kebun |
| **Buku Kas** | Semua transaksi masuk/keluar per kebun |
| **Rekap Gaji** | Per karyawan, per tipe, per kebun, per periode |
| **Rekap Panen** | Per kebun, per komoditas, per periode |

#### Export Laporan (untuk Manajer)
- 📄 **Export ke Word (.docx)** — Format laporan formal dengan header, tabel, foto bukti
- 📋 **Export ke PDF** — Format ringkas untuk arsip
- Setiap laporan bisa di-export dan langsung dikirim ke manajer

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Framework** | Laravel 11 |
| **Frontend** | Blade + Livewire 3 + Alpine.js |
| **UI Template** | AdminLTE 4 (Bootstrap 5) |
| **Database** | MySQL 8 |
| **Charts** | ApexCharts |
| **Auth** | Laravel Breeze (login simple) |
| **PDF Export** | DomPDF |
| **Word Export** | PhpWord (phpoffice/phpword) |
| **Excel Export** | Laravel Excel (Maatwebsite) |
| **File Storage** | Laravel Storage (local disk) |
| **Image Handling** | Intervention Image (resize/compress foto) |

## Struktur Direktori

```
kebun-finance/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/LoginController.php
│   │   ├── DashboardController.php
│   │   ├── KebunController.php
│   │   ├── KaryawanController.php
│   │   ├── KomoditasController.php
│   │   ├── TarifKupasController.php
│   │   ├── AbsensiController.php
│   │   ├── PanenController.php
│   │   ├── GajiBulananController.php
│   │   ├── UpahHarianController.php
│   │   ├── UpahBoronganController.php
│   │   ├── TransaksiController.php
│   │   ├── LaporanController.php
│   │   └── FotoBuktiController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Kebun.php
│   │   ├── Blok.php
│   │   ├── Karyawan.php
│   │   ├── Komoditas.php
│   │   ├── TarifKupas.php
│   │   ├── Absensi.php
│   │   ├── Panen.php
│   │   ├── GajiBulanan.php
│   │   ├── UpahHarian.php
│   │   ├── UpahBorongan.php
│   │   ├── FotoBukti.php
│   │   └── Transaksi.php
│   ├── Services/
│   │   ├── AbsensiService.php
│   │   ├── GajiService.php
│   │   ├── PanenService.php
│   │   ├── LaporanService.php
│   │   └── ExportService.php
│   ├── Exports/
│   │   ├── RekapMingguanWord.php
│   │   ├── RekapBulananWord.php
│   │   ├── RekapGajiExport.php
│   │   ├── RekapPanenExport.php
│   │   └── BukuKasExport.php
│   └── Traits/
│       └── HasFotoBukti.php        → Polymorphic foto relation
├── database/
│   ├── migrations/                  → 13 migration files
│   └── seeders/
│       ├── UserSeeder.php           → Default login user
│       ├── KomoditasSeeder.php
│       └── KategoriSeeder.php
├── resources/views/
│   ├── auth/
│   │   └── login.blade.php         → Halaman login
│   ├── layouts/app.blade.php       → AdminLTE layout
│   ├── dashboard.blade.php
│   ├── kebun/                       → index, create, edit
│   ├── karyawan/                    → index, create, edit
│   ├── absensi/                     → index, input-harian
│   ├── panen/                       → index, create (+ upload foto)
│   ├── gaji/                        → index, generate, detail
│   ├── upah-harian/                 → index, input, rekap-mingguan
│   ├── upah-borongan/               → index, input (+ foto), rekap-mingguan
│   ├── transaksi/                   → buku-kas
│   └── laporan/
│       ├── rekap-mingguan.blade.php
│       ├── rekap-bulanan.blade.php
│       └── pdf/                     → PDF templates
├── routes/web.php
├── storage/app/foto-bukti/          → Upload foto dari WhatsApp
└── public/
```

## Alur Kerja Supervisor

```mermaid
flowchart TD
    A[🔐 Login] --> B[🏠 Dashboard]

    B --> C[📝 Pencatatan Harian]
    C --> C1[Input Absensi]
    C --> C2[Input Hasil Kupas + Upload Foto]
    C --> C3[Input Panen + Upload Foto]

    B --> D[📊 Rekap Mingguan]
    D --> D1[Review Absen Minggu Ini]
    D --> D2[Review Total Upah Minggu Ini]
    D --> D3[Bayar Upah Mingguan]
    D --> D4[📄 Export Word / PDF → Kirim ke Manajer]

    B --> E[📅 Akhir Bulan]
    E --> E1[Generate Gaji Tetap dari Data Absen]
    E --> E2[Rekap Bulanan Semua Upah]
    E --> E3[Review Laba Rugi]
    E --> E4[📄 Export Word / PDF → Kirim ke Manajer]
```

## Contoh Tampilan Export Word

Laporan yang di-export ke Word akan berformat:

```
╔══════════════════════════════════════════════════╗
║  LAPORAN REKAP MINGGUAN PERKEBUNAN              ║
║  Kebun: Kebun Raya Utama                        ║
║  Periode: 10 Juni - 16 Juni 2026                ║
╠══════════════════════════════════════════════════╣
║                                                  ║
║  I. REKAP ABSENSI                               ║
║  ┌──────────────┬──────┬─────┬──────┬───────┐   ║
║  │ Nama         │Hadir │Izin │Sakit │ Alpha │   ║
║  ├──────────────┼──────┼─────┼──────┼───────┤   ║
║  │ Ahmad        │  6   │  0  │  0   │   0   │   ║
║  │ Budi         │  5   │  1  │  0   │   0   │   ║
║  └──────────────┴──────┴─────┴──────┴───────┘   ║
║                                                  ║
║  II. REKAP UPAH BORONGAN (KUPAS KELAPA)         ║
║  ┌──────────────┬────────┬───────┬──────────┐   ║
║  │ Nama         │Jumlah  │Tarif  │ Total    │   ║
║  ├──────────────┼────────┼───────┼──────────┤   ║
║  │ Ahmad        │500 btr │Rp 200 │Rp100.000 │   ║
║  │ Budi         │420 btr │Rp 200 │Rp 84.000 │   ║
║  └──────────────┴────────┴───────┴──────────┘   ║
║                                                  ║
║  III. FOTO BUKTI KERJA                          ║
║  [foto1.jpg] [foto2.jpg] [foto3.jpg]            ║
║                                                  ║
║  IV. REKAP PANEN                                ║
║  Total Kelapa: 2.500 butir (Rp 5.000.000)      ║
║                                                  ║
╚══════════════════════════════════════════════════╝
```
