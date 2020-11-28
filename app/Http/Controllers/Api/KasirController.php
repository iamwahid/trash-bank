<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use Illuminate\Support\Facades\Validator;
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
        $barang = $this->barang->get();
        return response()->json(['warga' => $warga, 'barang' => $barang], 200);
    }

    public function tukar_barang(Request $request, Warga $warga)
    {
        $validator = Validator::make($request->all(), [
            'barang' => 'required',
            'count' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();
        $barang = $this->barang->getById($data['barang']);
        unset($data['barang']);
        
        $this->warga->tukarBarang($warga, $barang, $data);
        return response()->json(['message' => 'Berhasil Tukar Barang'], 200);
    }

    public function ambil_point(Request $request, Warga $warga)
    {
        $validator = Validator::make($request->all(), [
            'point' => 'required|numeric',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();
        
        return $this->warga->ambilPoint($warga, $data);
    }
    
    public function konfirmasi(Request $request, Warga $warga)
    {
        $validator = Validator::make($request->all(), [
            'verif_code' => 'required',
            'trx_id' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();

        return $this->warga->konfirmasi($warga, $data);
    }

    public function scanBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();
        
        return $this->warga->scanBarcode($data['barcode']);
    }
}
