<?php

namespace App\Http\Controllers\Backend;

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
        return view('backend.warga.index', ['warga' => $warga]);
    }

    public function create()
    {
        return view('backend.warga.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_name' => ['required', 'string'], 
            'email' => ['required', 'string'], 
            'kelas' => ['required', 'string'], 
            'password' => ['required','confirmed'], 
        ]);

        $name = explode(' ', $data['user_name']);

        $user = $this->user->create([
            'first_name' => $name[0],
            'last_name' => isset($name[1]) ? $name[1] : '',
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
            'roles' => [config('access.users.default_role')]
        ]);
        $user->warga()->create([
            'kelas' => $data['kelas']
        ]);

        return redirect()->back()->withFlashSuccess('success');
    }

    public function edit(Request $request, Warga $warga)
    {
        return view('backend.warga.edit', ['warga' => $warga]);
    }

    public function update(Request $request, Warga $warga)
    {
        if (!$warga->id) return;
        $data = $request->validate([
            'user_name' => ['required', 'string'], 
            'kelas' => ['required', 'string'], 
        ]);

        $warga->user->name = $data['user_name'];
        $warga->kelas = $data['kelas'];
        return redirect()->back()->withFlashSuccess('success');
    }

    public function show(Warga $warga)
    {
        return view('backend.warga.show', ['warga' => $warga]);
    }

    public function destroy(Warga $warga)
    {
        $this->warga->deleteById($warga->id);
    }
}
