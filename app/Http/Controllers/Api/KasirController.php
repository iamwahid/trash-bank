<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use phpDocumentor\Reflection\Types\Void_;

class KasirController extends Controller
{
    protected $warga;
    protected $user;
    protected $barang;
    public function __construct(WargaRepository $warga, UserRepository $user, BarangRepository $barang)
    {
        $this->warga = $warga;
        $this->user = $user;
        $this->barang = $barang;
    }

    public function index()
    {
        $warga = $this->warga->get();
        $barang = $this->barang->where('type', 'barang')->get();
        $jualan = $this->barang->where('type', 'jualan')->get();
        return view('backend.kasir.index', ['warga' => $warga, 'barang' => $barang, 'jualan' => $jualan]);
    }

    public function tukar_barang(Request $request, Warga $warga)
    {
        if (strtolower($request->method()) == 'post') {
            $data = $request->validate([
                // 'user_name' => ['required', 'string'],
                // 'kelas' => ['required', 'string'],
                'barang' => ['required'],
                'jumlah' => ['required'],
                'total' => ['required'],
            ]);
            $barang = $this->barang->getById($data['barang']);
            // dd($barang);
            unset($data['barang']);
            if ($barang) {
                $total = (int) $data['jumlah'] * $barang->point;
                $data = array_merge([
                    'description' => $barang->name.' ('.$data['jumlah'].' x '.$barang->point.') '.$total.' Point',
                    'point' => $barang->point,
                    'point_total' => $warga->point_total + $total,
                ], $data);
                $this->warga->tukarBarang($warga, $data);
                return redirect()->route('admin.kasir.index')->withFlashSuccess('success');
            }
        } 

        $barang = $this->barang->where('type', 'barang')->get()->mapWithKeys(function($d){
            return [$d->id.'_'.$d->point => $d->name.' ('.$d->point.' Point)'];
        })->toArray();
        return view('backend.kasir.barang', ['warga' => $warga, 'barang' => $barang]);
    }

    public function tukar_point(Request $request, Warga $warga)
    {
        if (strtolower($request->method()) == 'post') {
            $data = $request->validate([
                'jumlah' => ['required', 'numeric'],
                'barang' => ['required'],
                'keterangan' => ['required'],
            ]);
            
            $barang = $this->barang->getById($data['barang']);
            unset($data['barang']);
            if ($barang) {
                $total = (int)$data['jumlah'] * $barang->point;
                if ($total > (int) $warga->point_total) return redirect()->back()->withErrors('Point tidak cukup');
                $data = array_merge([
                    'description' => $data['keterangan'].' -- Tukar point -> '.$barang->name.' ('.$data['jumlah'].' x '.$barang->point.') -'.$total,
                    'point' => $total,
                    'point_total' => $warga->point_total,
                ], $data);
                $result = $this->warga->tukarPoint($warga, $data);
                return redirect()->route('admin.kasir.konfirmasi', $warga->id)->withFlashSuccess('Konfirmasi Tukar Point');
            }
        } 

        $barang = $this->barang->where('type', 'jualan')->get()->mapWithKeys(function($d){
            return [$d->id.'_'.$d->point => $d->name.' - Harga '.$d->point.' Point'];
        })->toArray();

        return view('backend.kasir.point', ['warga' => $warga, 'barang' => $barang]);
    }
    
    public function konfirmasi(Request $request, Warga $warga)
    {
        if (strtolower($request->method()) == 'post') {
            $data = $request->validate([
                'verif_code' => ['required'],
            ]);
            
            if ($data['verif_code'] && $this->warga->konfirmasi($warga, $data['verif_code'])) {
                return redirect()->route('admin.kasir.index')->withFlashSuccess('success');
            }
            return redirect()->back()->withErrors("kode tidak valid");
        }

        return view('backend.kasir.konfirmasi', ['warga' => $warga]);
    }
}
