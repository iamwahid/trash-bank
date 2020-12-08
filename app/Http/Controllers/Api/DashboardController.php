<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use App\Models\PointHistory;
use App\Repositories\Backend\BarangRepository;
use App\Repositories\Backend\WargaRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use Arr;
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

    public function transaksiShow(Request $request, PointHistory $point)
    {
        $user = auth()->user();
        $point = $user->warga->points()->where('id', $point)->first();
        if ($point) {
            return response()->json($point->append('barcode'));
        }
        return response()->json([], 404);
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
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users',
            'mobile' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
            // 'avatar_type' => 'string',
            'avatar_location' => 'nullable',
            'rt' => 'nullable|string',
            'address' => 'nullable|string',
            'sex' => 'nullable|string',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        $data = $validator->validated();
        $user = $request->user();
        if (isset($data['name'])) {
            $name = explode(' ', $data['name']);
            $first = $name[0];
            unset($name[0]);
            unset($data['name']);
            $last = implode(' ', $name);
            $data['first_name'] = $first;
            $data['last_name'] = $last;
        }

        $output = $this->user->update(
            $user->id,
            Arr::only($data, ['first_name', 'last_name', 'email', 'mobile']),
            $request->has('avatar_location') ? $request->file('avatar_location') : false
        );

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        if ($user->warga) {
            $user->warga()->update(Arr::only($data, ['rt', 'address', 'sex']));
        }


        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && $output['email_changed']) {
            $request->user()->token()->revoke();
            // auth()->logout();

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
