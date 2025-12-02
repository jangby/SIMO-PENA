<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data PAC (Induk)
        Organization::create([
            'name' => 'PAC IPNU IPPNU Kecamatan Limbangan',
            'type' => 'PAC',
            'address' => 'Kecamatan Limbangan, Garut',
        ]);

        // 2. Daftar Ranting (Desa) - Silakan tambah/edit sesuai realita
        $rantings = [
            'PR Desa Limbangan Barat',
            'PR Desa Limbangan Timur',
            'PR Desa Limbangan Tengah',
            'PR Desa Galihpakuwon',
            'PR Desa Ciwangi',
            'PR Desa Pangeureunan',
            'PR Desa Surabaya',
            'PR Desa Simpen Kaler',
            'PR Desa Simpen Kidul',
            'PR Desa Dungusiru',
            'PR Desa Neglasari',
        ];

        foreach ($rantings as $pr) {
            Organization::create([
                'name' => $pr,
                'type' => 'PR',
                'address' => 'Kecamatan Limbangan',
            ]);
        }

        // 3. Daftar Komisariat (Sekolah/Pesantren)
        $komisariats = [
            'PK SMA NU 1 Limbangan',
            'PK SMK NU Limbangan',
            'PK MA Ma\'arif Limbangan',
            'PK MTs Yabar',
            'PK Pondok Pesantren As-Sa\'adah',
            'PK SMP N 1 Limbangan',
        ];

        foreach ($komisariats as $pk) {
            Organization::create([
                'name' => $pk,
                'type' => 'PK',
                'address' => 'Kecamatan Limbangan',
            ]);
        }
    }
}