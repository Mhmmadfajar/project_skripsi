<?php

namespace App\Controllers;

use App\Models\SuratModel;

class Verifikasi extends BaseController
{
    protected $suratModel;

    public function __construct()
    {
        $this->suratModel = new SuratModel();
    }

    public function surat(string $qr_code)
    {
        $surat = $this->suratModel->getByQrCode($qr_code);

        return view('verifikasi/surat', [
            'title'   => 'Verifikasi Keaslian Surat Desa',
            'surat'   => $surat,
            'qr_code' => $qr_code
        ]);
    }
}
