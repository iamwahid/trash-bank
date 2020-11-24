<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Repositories\Backend\BarangRepository;
use Illuminate\Http\Request;

class BarangController extends Controller
{

    protected $barang;
    public function __construct(BarangRepository $barang)
    {
        $this->barang = $barang;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = request()->get('type') ?? '';
        $grouped = request()->get('grouped') ?? '';
        $barang = $this->barang->type($type)->get();
        return response()->json($barang, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'point' => ['required', 'numeric'],
            'type' => ['required']
        ]);

        $this->barang->create($data);
        return response()->json(['message' => 'created'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Barang $barang)
    {
        return response()->json($barang, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Barang $barang)
    {
        if (!$barang->id) return;
        $data = $request->validate([
            'name' => ['required', 'string'],
            'point' => ['required', 'numeric'],
            'type' => ['required']
        ]);

        $barang->update($data);
        return response()->json(['message' => 'updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        if ($this->barang->deleteById($barang->id))
        return response()->json(['message' => 'deleted'], 200);
    }
}
