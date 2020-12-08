<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warga;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\WargaRepository;
use Illuminate\Support\Facades\Validator;

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
        $warga = $this->user->with('warga')
                ->role(config('access.users.default_role'))
                ->rt(request()->get('rt') ?? '')
                ->name(request()->get('name') ?? '')
                ->get();
        return response()->json($warga, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string', 
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',  
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'rt' => 'string',
            // 'is_koordinator' => 'boolean',
            'address' => 'required|string',
            'sex' => 'required|string',
            'confirm_agreement' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        
        $data = $validator->validated();

        $name = explode(' ', $data['user_name']);
        $first = $name[0];
        unset($name[0]);
        $last = implode(' ', $name);
        
        $duser = [
            'first_name' => $first,
            'last_name' => $last,
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => $data['password'],
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'confirm_agreement' => $data['confirm_agreement'] ?? false,
            'roles' => [config('access.users.default_role')]
        ];
        $user = $this->user->create($duser);

        $user->warga()->create([
            // 'place_of_birth' => $data['place_of_birth'],
            // 'birth_date' => $data['birth_date'],
            'address' => $data['address'],
            'sex' => $data['sex'],
            'rt' => $data['rt'],
            // 'is_koordinator' => $data['is_koordinator']
        ]);

        return response()->json(['message' => 'created'], 200);
    }

    public function update(Request $request, Warga $warga)
    {
        if (!$warga->id) return;
        $data = $request->validate([
            'user_name' => ['string'], 
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'rt' => 'string',
            // 'is_koordinator' => 'boolean',
            'address' => 'string',
            'sex' => 'string',
        ]);

        $warga->user->name = $data['user_name'];
        unset($data['user_name']);
        $warga->update($data);
        return response()->json(['message' => 'updated'], 200);
    }

    public function show(Warga $warga)
    {
        $type = request()->get('type') ?? '';
        $war = clone $warga;
        $war->points = $warga->points()->type($type)->get();
        return response()->json($war, 200);
    }

    public function destroy(Warga $warga)
    {
        if ($this->warga->deleteById($warga->id)) {
            return response()->json(['message' => 'deleted'], 200);
        }
    }
}
