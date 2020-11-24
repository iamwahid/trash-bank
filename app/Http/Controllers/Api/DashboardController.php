<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }

    public function mineJson(Request $request) // mhs
    { 
        return $request->all();
        // $mybimbingan = auth()->user()->bimbingan;
        $data = [
            // 'data' => $mybimbingan, 
            // 'status' => $mybimbingan && $mybimbingan->deskripsi ? 'Revisi' : 'Pengajuan', 
        ];

        return response()->json($data, 201);
    }
}
