<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Role;
use App\Models\Auth\User;
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
        $query = $this->user->with(['warga', 'roles'])
                // ->role([])
                ->where("id", request()->user()->id, '!=')
                ->name(request()->get('name') ?? '');

        if (request()->user()->isAdmin()) {
            $query = $query->rt(request()->get('rt') ?? '');
        } else if (request()->user()->isKoordinator()) {
            $rt = request()->user()->warga ? request()->user()->warga->rt : "";
            $query = $query->rt($rt);
        }

        $warga = $query->get();
        return response()->json($warga, 200);
    }
    
    public function index_per_rt($rt)
    {
        // $rt = '03';
        $warga = $this->user->with(['warga', 'roles'])
                // ->role([])
                ->where("id", request()->user()->id, '!=')
                ->rt(request()->get('rt') ?? $rt)
                ->name(request()->get('name') ?? '')
                ->get();
        return response()->json($warga, 200);
    }

    public function summary()
    {
        $result = [];

        $query = $this->warga;

        if (request()->user()->isAdmin()) {
            $warga = $query->get();
            foreach (config('trashbank.rt_list') as $rt) {
                $result['rt_point_totals'][$rt] = $warga->where('rt', $rt)->reduce(function($res, $i){
                    return $res + $i->point_total;
                }, 0);
            } 
        } else if (request()->user()->isKoordinator()) {
            $rt = request()->user()->warga ? request()->user()->warga->rt : "";
            if (!$rt) return response()->json($result, 404);
            $warga = $query->where('rt', $rt)->get();
            $result = [
                'rt_point_total' => $warga->reduce(function($res, $i){
                    return $res + $i->point_total;
                }, 0),
            ]; 
        }
        

        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string', 
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'password' => 'required|string|confirmed',  
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'rt' => 'string',
            'address' => 'required|string',
            'sex' => 'required|string',
            'confirm_agreement' => 'required',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);
        
        $data = $validator->validated();

        $name = explode(' ', $data['name']);
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

    public function update(Request $request, User $user)
    {
        if (!$user->id) return;
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string', 
            'email' => 'nullable|email|unique:users',
            'mobile' => 'nullable',
            'password' => 'nullable|min:8|confirmed',
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'rt' => 'nullable|string',
            'address' => 'nullable|string',
            'sex' => 'nullable|string',
        ]);
        if ($validator->fails()) return response()->json(['errors' => $validator->errors()], 422);

        $data = $validator->validated();
        $data = collect($data)->filter()->toArray();

        if (isset($data['name'])) {
            $user->name = $data['name'];
            unset($data['name']);
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
            unset($data['email']);
        }
        
        if (isset($data['mobile'])) {
            $user->mobile = $data['mobile'];
            unset($data['mobile']);
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
            unset($data['password']);
        }

        $user->save();

        if ($user->warga) {
            $user->warga->update($data);
        }

        return response()->json(['message' => 'updated'], 200);
    }

    public function show(User $user)
    {
        $type = request()->get('type') ? explode(',', request()->get('type')) : [];
        if (!$user->warga) {
            return response()->json([], 404);
        }
        $warg = clone $user->warga;
        $warg->points = $user->warga->points()->type($type)->get();
        return response()->json($warg, 200);
    }

    public function destroy(User $user)
    {
        if ($this->user->deleteById($user->id)) {
            return response()->json(['message' => 'deleted'], 200);
        }
    }

    public function assignRole(User $user, $role)
    {
        $role = Role::where('name', $role)->first();
        abort_unless($user && $role, 404);
        $user->syncRoles([$role]);
        return response()->json(['message' => "Berhasil ubah sebagai $role->name"]);
    }
}
