<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\WargaRepository;
use phpDocumentor\Reflection\Types\Void_;

class TransaksiController extends Controller
{
    protected $warga;
    protected $user;
    public function __construct(WargaRepository $warga, UserRepository $user)
    {
        $this->warga = $warga;
        $this->user = $user;
    }

    public function index()
    {
        $trx = PointHistory::get();
        // dd($trx);
        return view('backend.transaksi.index', ['trx' => $trx]);
    }
}
