<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class ImpersonateController extends Controller
{
    public function start(User $user){
        session()->put('impersonate_by',auth()->id());
        Auth::login($user);
        return redirect('/home');
    }

    public function stop(User $user){
        $user = auth()->user();
        Auth::loginUsingId(session()->pull('impersonate_by'));
        return redirect()->route('users.show', compact('user'));
    }

}
