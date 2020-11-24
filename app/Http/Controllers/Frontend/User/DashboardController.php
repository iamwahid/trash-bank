<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\BarangRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{

    protected $barang;
    public function __construct(BarangRepository $barang)
    {
        $this->barang = $barang;
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $barang = $this->barang->where('type', 'barang')->get();
        $jualan = $this->barang->where('type', 'jualan')->get();
        return view('frontend.user.dashboard', ['barang' => $barang, 'jualan' => $jualan]);
    }

    public function transaksi()
    {
        return view('frontend.user.transaksi');
    }
}
