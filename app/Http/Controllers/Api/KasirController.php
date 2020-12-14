<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PointHistory;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use DB;
use Illuminate\Support\Facades\Validator;

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
            'count' => 'required|between:0,999.999',
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

    public function verifyBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();
        
        return $this->warga->scanTrxBarcode($data['barcode']);
    }

    public function getByTrxBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();

        $decoded = $this->warga->decodeBarcode($data['barcode']);

        if ($decoded) {
            $transaksi = PointHistory::with(['warga.user'])->find($decoded[0]);
            return response()->json($transaksi);
        }

        return response()->json([], 404);
    }

    public function getByBarcode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();

        return $this->warga->scanBarcode($data['barcode']);
    }

    public function getAllPointTotal()
    {
        $wargapoints = DB::select("SELECT SUM(point_total) AS total FROM warga");
        $adminpoints = DB::select("SELECT SUM(point_total) AS total FROM point_history WHERE type = 'admin'");
        return response()->json( [
            'warga' => $wargapoints && isset($wargapoints[0]) ? $wargapoints[0]->total : 0,
            'admin' => $adminpoints && isset($adminpoints[0]) ? $adminpoints[0]->total : 0
        ]);
        
    }
}
