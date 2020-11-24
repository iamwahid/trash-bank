<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Auth\SocialiteHelper;
use App\Http\Requests\RegisterRequest;
use App\Events\Frontend\Auth\UserRegistered;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        abort_unless(config('access.registration'), 404);

        return view('frontend.auth.register-siswa');
            // ->withSocialiteLinks((new SocialiteHelper)->getSocialLinks());
    }

    /**
     * @param Request $request
     *
     * @throws \Throwable
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        abort_unless(config('access.registration'), 404);

        // $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        $data = $request->validate([
            'user_name' => ['required', 'string'], 
            'email' => ['required', 'string'], 
            'kelas' => ['required', 'string'], 
            'password' => ['required','confirmed', 'min:8'], 
        ]);

        $name = explode(' ', $data['user_name']);

        $user = $this->userRepository->create([
            'first_name' => $name[0],
            'last_name' => isset($name[1]) ? $name[1] : '',
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmation_code' => md5(uniqid(mt_rand(), true)),
            'confirmed' => true,
        ]);


        $user->siswa()->create([
            'kelas' => $data['kelas']
        ]);

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            // event(new UserRegistered($user));

            return redirect($this->redirectPath())->withFlashSuccess(
                config('access.users.requires_approval') ?
                    __('exceptions.frontend.auth.confirmation.created_pending') :
                    __('exceptions.frontend.auth.confirmation.created_confirm')
            );
        }

        auth()->login($user);

        // event(new UserRegistered($user));

        return redirect($this->redirectPath());
    }
}
