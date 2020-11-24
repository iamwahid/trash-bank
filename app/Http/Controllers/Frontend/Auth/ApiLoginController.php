<?php
namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Repositories\Frontend\Auth\UserRepository;
use Arr;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|string|unique:users',
            // 'place_of_birth' => 'required|string',
            // 'birth_date' => 'required|string',
            'address' => 'required|string',
            'sex' => 'required|string',
            'password' => 'required|string|confirmed',
            'confirm_agreement' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $user = $this->users->register($data);
        return response()->json([
            'message' => 'Successfully register!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $validator->validated();
        $credentials = Arr::only($data, ['email', 'password']);
        if(!Auth::attempt($credentials, $data['remember_me']))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $this->users->with('roles', 'permissions')->getById(auth()->user()->id);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        $token = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        $user = $request->user();
        if(!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }
        return response()->json($this->users->with('roles', 'warga', 'warga.points')->getById($user->id), 200);
    }

    public function refresh(Request $request)
    {
        $user = auth()->user();
        if(!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        $token = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ];
        return response()->json([
            'user' => auth()->user(),
            'token' => $token,
        ]);
    }
}
