<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    protected $barang;
    protected $warga;
    public function __construct(BarangRepository $barang, WargaRepository $warga)
    {
        $this->barang = $barang;
        $this->warga = $warga;
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
            'type' => ['required'],
            'counter' => 'nullable'
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
            'type' => ['required'],
            'counter' => 'nullable'
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

    public function summary(Request $request)
    {
        $scope = $request->get('scope');
        $barang_id = $request->get('barang_id');
        $warga_id = $request->get('warga_id');
        $rt = $request->get('rt');

        if ($request->user()->isAdmin()) {
            if ($scope == "warga") {
                $q = "SELECT `points`.`warga_id`, `points`.`barang_id`, `points`.`type_count`, 
                `warga`.`rt`, `warga`.`fullname`, `warga`.`user_id`,
                `barang`.`name` as `nama_barang` FROM `barang`
                LEFT JOIN (
                    SELECT *, SUM(`count`) as `type_count` FROM `point_history` 
                    WHERE `point_history`.`type` = 'tukar'
                    GROUP BY `barang_id`
                ) as `points` ON `points`.`barang_id` = `barang`.`id`
                LEFT JOIN (
                    SELECT `warga`.`id`, `user_id`, `rt`, CONCAT(`first_name`, ' ', `last_name`) as `fullname` FROM `warga`
                    LEFT JOIN `users` ON `users`.`id` = `warga`.`user_id`
                ) as `warga` ON `points`.`warga_id` = `warga`.`id`
                WHERE `points`.`type` = 'tukar' ";

                if ($barang_id) {
                    $q .= "AND `barang`.`id` = $barang_id ";
                }
        
                if ($warga_id) {
                    $q .= "AND `warga`.`id` = $warga_id ";
                }
            } else if ($scope == "rt") {
                $q = "SELECT `points`.`warga_id`, `points`.`barang_id`, `points`.`type_count`, 
                `warga`.`rt`, `warga`.`fullname`, `warga`.`user_id`,
                `barang`.`name` as `nama_barang` FROM `barang`
                LEFT JOIN (
                    SELECT *, SUM(`count`) as `type_count` FROM `point_history` 
                    WHERE `point_history`.`type` = 'tukar'
                    GROUP BY `barang_id`
                ) as `points` ON `points`.`barang_id` = `barang`.`id`
                LEFT JOIN (
                    SELECT `warga`.`id`, `user_id`, `rt`, CONCAT(`first_name`, ' ', `last_name`) as `fullname` FROM `warga`
                    LEFT JOIN `users` ON `users`.`id` = `warga`.`user_id`
                ) as `warga` ON `points`.`warga_id` = `warga`.`id`
                WHERE `points`.`type` = 'tukar' AND `warga`.`rt` = '$rt' 
                ";
                if ($barang_id) {
                    $q .= "AND `barang`.`id` = $barang_id ";
                }
        
                if ($warga_id) {
                    $q .= "AND `warga`.`id` = $warga_id ";
                }
            } else {
                $q = "SELECT `barang`.`counter` as `banyak_barang`, `barang`.`name` as `nama_barang` FROM `barang` ";
                
                if ($barang_id) {
                    $q .= "WHERE `barang`.`id` = $barang_id ";
                }
            }
        } else if ($request->user()->isKoordinator()) {
            $rt = $request->user()->warga->rt;
            if ($scope == "warga") {
                $q = "SELECT `points`.`warga_id`, `points`.`barang_id`, `points`.`type_count`, 
                    `warga`.`rt`, `warga`.`fullname`, `warga`.`user_id`,
                    `barang`.`name` as `nama_barang` FROM `barang`
                    LEFT JOIN (
                        SELECT *, SUM(`count`) as `type_count` FROM `point_history` 
                        WHERE `point_history`.`type` = 'tukar'
                        GROUP BY `barang_id`
                    ) as `points` ON `points`.`barang_id` = `barang`.`id`
                    LEFT JOIN (
                        SELECT `warga`.`id`, `user_id`, `rt`, CONCAT(`first_name`, ' ', `last_name`) as `fullname` FROM `warga`
                        LEFT JOIN `users` ON `users`.`id` = `warga`.`user_id`
                    ) as `warga` ON `points`.`warga_id` = `warga`.`id`
                    WHERE `points`.`type` = 'tukar' AND `warga`.`rt` = '$rt' ";
            } else {
                $q = "SELECT `points`.`warga_id`, `points`.`barang_id`, `points`.`type_count`, 
                    `warga`.`rt`, `warga`.`fullname`, `warga`.`user_id`,
                    `barang`.`name` as `nama_barang` FROM `barang`
                    LEFT JOIN (
                        SELECT *, SUM(`count`) as `type_count` FROM `point_history` 
                        WHERE `point_history`.`type` = 'tukar'
                        GROUP BY `barang_id`
                    ) as `points` ON `points`.`barang_id` = `barang`.`id`
                    LEFT JOIN (
                        SELECT `warga`.`id`, `user_id`, `rt`, CONCAT(`first_name`, ' ', `last_name`) as `fullname` FROM `warga`
                        LEFT JOIN `users` ON `users`.`id` = `warga`.`user_id`
                    ) as `warga` ON `points`.`warga_id` = `warga`.`id`
                    WHERE `points`.`type` = 'tukar' AND `warga`.`rt` = '$rt' ";
            }
            if ($barang_id) {
                $q .= "AND `barang`.`id` = $barang_id ";
            }
    
            if ($warga_id) {
                $q .= "AND `warga`.`id` = $warga_id ";
            }
        }

        $data = DB::select($q);

        return response()->json($data, 200);


    }
}
