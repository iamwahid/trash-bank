<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\WargaRepository;
use phpDocumentor\Reflection\Types\Void_;

class WargaController extends Controller
{
    protected $warga;
    protected $user;
    public function __construct(WargaRepository $warga, UserRepository $user)
    {
        $this->warga = $warga;
        $this->user = $user;
    }

    public function index()
    {
        $warga = $this->warga->get();
        return response()->json($warga, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_name' => 'required|string', 
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',  
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'address' => 'required|string',
            'sex' => 'required|string',
            'confirm_agreement' => 'required',
        ]);

        $name = explode(' ', $data['user_name']);
        $duser = [
            'first_name' => $name[0],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => $data['password'],
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'confirm_agreement' => $data['confirm_agreement'] ?? false,
            'roles' => [config('access.users.default_role')]
        ];
        unset($name[0]);
        $duser['last_name'] = implode(' ', $name);
        $user = $this->user->create($duser);

        $user->warga()->create([
            // 'place_of_birth' => $data['place_of_birth'],
            // 'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'sex' => $data['sex'],
        ]);

        return response()->json(['message' => 'created'], 200);
    }

    public function update(Request $request, Warga $warga)
    {
        if (!$warga->id) return;
        $data = $request->validate([
            'user_name' => ['required', 'string'], 
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'address' => 'required|string',
            // 'sex' => 'required|string', 
        ]);

        $warga->user->name = $data['user_name'];
        unset($data['user_name']);
        $warga->update($data);
        return response()->json(['message' => 'updated'], 200);
    }

    public function show(Warga $warga)
    {
        return response()->json($warga, 200);
    }

    public function destroy(Warga $warga)
    {
        if ($this->warga->deleteById($warga->id)) {
            return response()->json(['message' => 'deleted'], 200);
        }
    }
}
