<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Repositories\Backend\BarangRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $barang = $this->barang->type($type)->orderBy('type')->get();
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'point' => ['required', 'numeric'],
            'type' => ['required']
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        
        $data = $validator->validated();
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
        
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'point' => ['required', 'numeric'],
            'type' => ['required']
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        
        $data = $validator->validated();

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
