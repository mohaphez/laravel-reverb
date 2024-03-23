<?php

declare(strict_types=1);

namespace Themes\Mars\Http\Controllers\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Http\Controllers\Web\V1\BaseController;

class LoginController extends BaseController
{
    public function show(Request $request)
    {
        if(Auth::check()) {
            return redirect()->route('client.dashboard');
        }

        return view("auth.login");
    }

    public function login(Request $request)
    {
        $validated = $this->validate($request, [
            'email'    => ['required','email'],
            'password' => 'required'
        ]);

        if(Auth::attempt($validated)) {
            return redirect()->route('client.dashboard');
        }

        return redirect(route('home'))->with('errors', ['Invalid credentials. Please try again.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('home'));
    }
}
