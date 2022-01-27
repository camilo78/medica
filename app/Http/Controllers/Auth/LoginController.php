<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        $user  =  User::find(Auth::user()->id);
        $properties = json_decode('{"attributes":'. $user .'}');
        activity('user')
            ->causedBy(Auth::User()->id)
            ->performedOn($user)
            ->log('Ingresó al sistema');
        if ($user->getRoleNames()->first() == 'Paciente') {
            return '/users/' . Auth::User()->id;
        }elseif ($user->getRoleNames()->first() == 'Asistente') {
            return '/users';
        }else{
            return '/home';
        }

    }
    public function logout(){
        $user  =  User::find(Auth::user()->id);
        $properties = json_decode('{"attributes":'. $user .'}');
        activity('user')
            ->causedBy(Auth::User()->id)
            ->performedOn($user)
            ->log('Salió del sistema');
        Auth::logout();
        return view('welcome');
    }
}
