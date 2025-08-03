<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public $serverKey = 'SB-Mid-server-sQIOvET0PN0icODCdQadnjfn';
    public $clientKey = 'SB-Mid-client-hCVwpeiZXPpOwiJh';
    public $isProduction = false; // Ubah menjadi true di production environment
    public $isSanitized = true;
    public $is3ds = true;
}
