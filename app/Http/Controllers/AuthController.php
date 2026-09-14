<?php
namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

  public function redirectToProvider()
  {
    return Socialite::driver('google')->redirect();
  }

  public function handleGoogleAuth()
  {
    try {
      $google = Socialite::driver('google')->user();
      $user   = User::where('provider_auth', 'google')->where('id_auth_user', $google->id)->first();

      if (! $user) {
        $user = User::create([
          'id_user'       => strtotime(now()) . uniqid(),
          'name'          => $google->name,
          'username'      => $google->user->nickname ?? $google->name . uniqid(),
          'email'         => $google->email,
          'password'      => Hash::make(env('NEW_USER_PASSWORD')),
          'id_auth_user'  => $google->id,
          'provider_auth' => 'google',
          'created_at'    => now(),
          'created_by'    => 'controller',
          'updated_at'    => NULL,
        ]);
      }

      Auth::login($user);

      return redirect()->route('dashboard.index');
    } catch (Exception $e) {
      return redirect()->route('/login')->withErrors(['email' => 'Something wrong.']);
    }
  }

  public function profile()
  {
    $user = User::where('id_user', Auth::id())->first();

    return Inertia('Dashboard/profile', compact('user'));
  }

  public function login()
  {
    return Inertia('Auth/login');
  }

  public function storeLogin(Request $request)
  {
    $validators = Validator::make($request->all(), [
      'username' => 'required',
      'password' => 'required',
      'remember' => 'sometimes',
    ]);

    if ($validators->fails()) {
      return redirect()->route('login')->withInput()->withErrors($validators);
    }
    try {
      $user = User::where('username', $request->username)->first();
      if (!$user) {
        return redirect()->route('login')->withErrors(['username' => 'Your username or account is not found.']);
      }

      $credentials = $request->only('username', 'password');
      $remember    = $request->boolean('remember');

      if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard.index');
      }

      return redirect()->route('login')->withInput()->withErrors(['username' => 'Username or password incorrect.']);
    } catch (Exception $e) {
      return redirect()->route('login')->withInput()->withErrors(['username' => 'Username or password incorrect.']);
    }
  }

  public function register()
  {
    return Inertia('Auth/register');
  }

  public function storeRegister(Request $request)
  {
    $validators = Validator::make($request->all(), [
      'name'     => 'required',
      'username' => 'required|unique:users,username',
      'email'    => 'required|unique:users,email',
      'password' => 'required|confirmed',
    ]);

    if ($validators->fails()) {
      return redirect()->route('register')->withInput()->withErrors($validators);
    }

    try {
      $user = User::create([
        'id_user'       => strtotime(now()) . uniqid(),
        'name'          => $request->name,
        'username'      => Str::slug($request->name),
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
        'id_auth_user'  => null,
        'provider_auth' => 'email',
        'created_at'    => now(),
        'created_by'    => 'register',
        'updated_at'    => NULL,
      ]);

      return redirect()->route('login');
    } catch (Exception $e) {
      return redirect()->route('register')->withInput()->withErrors($validators);
    }
  }

  public function forgotPassword()
  {
    return Inertia('Auth/forgot-password');
  }

  public function storeForgotPassword()
  {

  }

  public function logout(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    return redirect()->route('index');
  }
}
