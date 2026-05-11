#!/bin/bash

# Script untuk mengupdate semua file admin dari layouts.app ke layouts.admin

echo "🔄 Updating admin layout files..."

# Array of files to update
files=(
    "resources/views/admin/users/profile.blade.php"
    "resources/views/admin/users/edit.blade.php"
    "resources/views/admin/users/create.blade.php"
    "resources/views/admin/users/activity-log.blade.php"
    "resources/views/admin/struktur/index.blade.php"
    "resources/views/admin/struktur/edit.blade.php"
    "resources/views/admin/struktur/create.blade.php"
    "resources/views/admin/struktur/bagan.blade.php"
    "resources/views/admin/periode-pendaftaran/index.blade.php"
    "resources/views/admin/periode-pendaftaran/edit.blade.php"
    "resources/views/admin/periode-pendaftaran/create.blade.php"
    "resources/views/admin/pengajuan_bantuan/show.blade.php"
    "resources/views/admin/pengajuan_bantuan/index.blade.php"
    "resources/views/admin/pelatihan/peserta.blade.php"
    "resources/views/admin/pelatihan/index.blade.php"
    "resources/views/admin/pelatihan/edit.blade.php"
    "resources/views/admin/pelatihan/create.blade.php"
    "resources/views/admin/laporan/umkm.blade.php"
    "resources/views/admin/laporan/sertifikat.blade.php"
    "resources/views/admin/laporan/koperasi.blade.php"
    "resources/views/admin/laporan/bantuan.blade.php"
    "resources/views/admin/koperasi/show.blade.php"
    "resources/views/admin/koperasi/edit.blade.php"
    "resources/views/admin/koperasi/create.blade.php"
    "resources/views/admin/kontak/show.blade.php"
    "resources/views/admin/kontak/index.blade.php"
    "resources/views/admin/halaman_statis/index.blade.php"
    "resources/views/admin/halaman_statis/edit.blade.php"
    "resources/views/admin/halaman_statis/create.blade.php"
    "resources/views/admin/galeri/create.blade.php"
    "resources/views/admin/chat/show.blade.php"
    "resources/views/admin/chat/index.blade.php"
    "resources/views/admin/berita/create.blade.php"
    "resources/views/admin/bantuan/create.blade.php"
    "resources/views/admin/anggota/edit.blade.php"
    "resources/views/admin/anggota/dokumen.blade.php"
    "resources/views/admin/anggota/create.blade.php"
)

count=0
for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        # Replace layouts.app with layouts.admin
        sed -i "s/@extends('layouts\.app')/@extends('layouts.admin')/g" "$file"
        
        # Remove @section('page-title') lines
        sed -i "/@section('page-title'/d" "$file"
        
        echo "✅ Updated: $file"
        ((count++))
    else
        echo "⚠️  File not found: $file"
    fi
done

echo ""
echo "✨ Done! Updated $count files."
echo "🔄 Please refresh your browser with Ctrl+Shift+R"
