<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\LuaranPkm;
use App\Models\User;
use App\Models\OperatorPt;
use App\Models\PerguruanTinggi;
use App\Models\ProgramStudi;
use App\Models\SkemaPkm;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        PerguruanTinggi::create([
            'kode_pt' => '005004',
            'nama_pt' => 'Politeknik Negeri Bandung',
            'username' => 'polban1',
            'password' => Hash::make('pass123'),
        ]);

        OperatorPt::create([
            'username' => 'op1',
            'password' => Hash::make('1234'),
            'kode_pt' => '005004',
        ]);

        SkemaPkm::create([
            'nama_skema' => 'Karsa Cipta',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Karya Inovatif',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Kewirausahaan',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Penerapan IPTEK',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Pengabdian Kepada Masyarakat',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Riset Eksakta',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Riset Sosial Humaniora',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Video Gagasan Konstruktif',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Artikel Ilmiah',
        ]);
        SkemaPkm::create([
            'nama_skema' => 'Gagasan Futuristik Tertulis',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Laporan Kemajuan',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Laporan Akhir',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Artikel Ilmiah',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Akun Media Sosial',
        ]);
        LuaranPkm::create([
        'nama_luaran' => 'Produk dan Aktivitas Usaha',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Buku Pedoman Mitra',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Prototipe/Produk Fungsional',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Produk Fungsional Skala Penuh beserta Dokumen Teknis',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Video YouTube',
        ]);
        LuaranPkm::create([
            'nama_luaran' => 'Artikel Gagasan',
        ]);

        ProgramStudi::create([
            'kode_prodi' => '56401',
            'nama_prodi' => 'D3-Teknik Informatika',
            'kode_pt' => '005004',
        ]);
        Dosen::create([
            'nidn' => '2214567',
            'nama' => 'Jonner Hutahaean',
            'no_hp' => '089526154777',
            'email' => 'jonner@polban.ac.id',
            'prodi_id' => '56401',
        ]);
    }
}
