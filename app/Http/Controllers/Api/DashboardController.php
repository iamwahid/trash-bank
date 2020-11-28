<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
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

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        return response()->json($this->user->with('warga')->getById($user->id));
    }

    public function transaksi(Request $request)
    {
        $user = auth()->user();
        $type = $request->get('type') ?? '';
        $transaksi = $user->warga->points()->type($type)->get()->map(function($d){
            return $d->append('barcode');
        });
        return response()->json($transaksi);
    }

    public function ambil_point()
    {
        $validator = Validator::make(request()->all(), [
            'point' => 'required|numeric',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();
        $user = auth()->user();
        
        return $this->warga->ambilPoint($user->warga, $data);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'string',
            'email' => 'string|email',
            'avatar_type' => 'string',
            'avatar_location' => 'string',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();
        
        $name = explode(' ', $data['name']);
        $first = $name[0];
        unset($name[0]);
        unset($data['name']);
        $last = implode(' ', $name);
        $data['first_name'] = $first;
        $data['last_name'] = $last;

        $output = $this->user->update(
            $request->user()->id,
            $data,
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            auth()->logout();

            return response()->json(['message' => 'Email diganti, silahkan login ulang']);
        }

        return response()->json(['message' => 'Data anda sudah diperbarui']);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->user->updatePassword($request->only('old_password', 'password'));

        return response()->json(['message' => 'Password anda sudah diperbarui']);
    }
}
