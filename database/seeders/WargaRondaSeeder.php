<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WargaRonda;
use Illuminate\Support\Facades\Schema; // <--- 1. Tambahkan baris ini di atas

class WargaRondaSeeder extends Seeder
{
    public function run(): void
    {
        // 2. Matikan pengecekan foreign key sebentar agar tabel bisa dikosongkan
        Schema::disableForeignKeyConstraints();
        WargaRonda::truncate();
        Schema::enableForeignKeyConstraints();

        $wargaList = [
            ['A. BUDIONO', 'IE-1/61'],
            ['AAM HIDAYAT', 'IE-1/39'],
            ['H. SUMARDIYONO', 'IE-1/25'],
            ['AMIN SUTRISNO', 'IE-2/12B'],
            ['NANDA SARTONO', 'IE-1/53'],
            ['SUDARTO', 'IE-5/3'],
            ['ZAINUDDIN', 'IE-5/13'],
            ['HERI P.', 'IE-3/8'],
            ['IBNU', 'IE/71'],
            ['A. KHUSAIRI', 'IE-1/9'],
            ['YUSWANTO', 'IE-2/3A'],
            ['TEGUH', 'IE-5/5'],
            ['ALIF MADURA', 'IE/69'],
            ['BAGUS', 'IE-1/24'],
            ['SATIM', 'IE-3/9'],
            ['SUTRISNO', 'IE-1/12A'],
            ['RANDI CILOK', 'IE-1/3'],
            ['IKBAL - TIARA', 'IE-5/6'],
            ['ADE SUPRIYADI', 'IE-1/71'],
            ['PRAYITNO', 'IE-2/8'],
            ['HARIYANTO', 'IE-1/20'],
            ['M. SIDIQ ILYAS', 'IE-1/59'],
            ['ARIS M.', 'IE-1/56'],
            ['IHSANNUDIN', 'IE-1/20'],
            ['ANDRIAN', '13-3/7'],
            ['WAWAN KUSWARNA', 'IE/82'],
            ['BESAR', 'IE-3/9'],
            ['B. SUHERMAN', 'IE-1/63'],
            ['SUMHADI', 'IE-3/6'],
            ['H. MASDAR', 'IE-1/53A'],
            ['ARI TRIS SUDIONO', 'IE-4/15'],
            ['PANJI', 'IE-4/11'],
            ['ADE JAMALUDIN', 'IE-1/52'],
            ['YOHANES WAHYU', 'IE-1/34'],
            ['NUGROHO T.M', 'IE-1/7'],
            ['NGADIYO', 'IE-1/15'],
            ['GATOT AGUNG S.', 'IE-1/58'],
            ['OVAL', 'IE-1/50'],
            ['SYAHRONI', 'IE-1/67'],
            ['DEDE', 'IE-1/26'],
            ['ANGGAKARA P.', 'IE-5/11'],
            ['K. YUSUF, SE', 'IE-2/9'],
            ['W.A TYASMONO', 'IE-1/10'],
            ['ANTON K.', 'IE-2/5'],
            ['TAUFIK H, SE', 'IE-2/15'],
            ['SYAHYONO', 'IE-1/69'],
            ['SLAMET AVIANTO', 'IE-1/32'],
            ['TUKIJO', 'IE-3/12A'],
            ['SUTAPA', 'IE-5/18'],
            ['B. SUPRAYITNO', 'IE-2/3A'],
            ['KHAERUDIN', 'IE-1/8'],
            ['SUSENO', 'IE-1/68'],
            ['ABD. BASYID', 'IE-5/12'],
            ['NIZAR', 'IE-1/19'],
            ['ARDI KADARUSMAN', 'IE-1/51'],
            ['MARYONO', 'IE-2/3A'],
            ['JONI SANTOSO', 'IE-5/7'],
            ['SUTRISNO (NISA)', 'IE-1/17'],
            ['SUNEBJ', 'IE/84'],
            ['IFFAT', 'IE-1/38'],
            ['DANAR', 'IE-1/12A'],
            ['A. GULTOM', 'IE-4/17'],
            ['ADI IQRO', 'IE-1/21'],
            ['H. BUDI', 'IE-5/3A'],
            ['SOLIHATNO', 'IE-3/11'],
            ['HARYANTO', 'IE-4/1'],
            ['DIMAS', 'IE-3/17'],
            ['SUNARI', 'IE-1/29'],
            ['FAJAR PURWANTO', 'IE-1/23A'],
            ['DWI ANAS', 'IE-1/60'],
            ['MARYADI, S.T', 'IE-1/23'],
            ['GUNAWAN', 'IE-1/12'],
            ['EMIN', 'IE-4/9'],
            ['H. ABDUL RASYID', 'IE-4/2'],
            ['MARYADI', 'IE-5/9'],
            ['P. MANALU', 'IE-5/36'],
            ['SENDI', 'IE-2/8'],
            ['KASERI', 'IE-1/66'],
            ['ALEK', 'IE-1/18'],
            ['SATRIA (ISTIANAH)', 'IE-4/8'],
            ['RENALDI G.', 'IE-1/15'],
            ['ALI MURSIDI', 'IE-2/1-2'],
            ['SUNARTA', 'IE-1-35'],
            ['GUNADI', 'IE-/81'],
            ['SUHENDRA H.', 'IE-5/10'],
            ['IMAM (BU SALAM)', 'IE-1/57'],
            ['SATAMIN', 'IE-3/10'],
            ['EDI PURWANTO', 'IE-5/1'],
            ['REJO BASUKI', 'IE-5/12'],
            ['HENDRIK', 'IE-3/5'],
            ['CECEP TIRTA', 'IE-1/39a'],
            ['DRS. H. NUR HASYIM', 'IE-1/63'],
            ['KRISTYAN S.', 'IE-1/5'],
            ['SAPARDI', 'IE-2/3'],
            ['A. MANALU', 'IE-1/27'],
            ['DADANG P.', 'IE/83'],
            ['PUJI PRIYO', 'IE-5/11']
        ];

        foreach ($wargaList as $data) {
            WargaRonda::create([
                'nama' => $data[0],
                'blok_rumah' => $data[1],
                'status_aktif' => true
            ]);
        }
    }
}