<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{

    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }
    
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }
}
