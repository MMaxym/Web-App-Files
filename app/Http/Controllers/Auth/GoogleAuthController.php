<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Google\Client as GoogleClient;
use Google\Service\PeopleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account consent'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (!$googleUser->getEmail()) {
                return redirect()->route('login')->withErrors('Google Error!');
            }

            $first_name = $googleUser->getName();
            $last_name = $googleUser->user['family_name'];
            $email = $googleUser->getEmail();
            $avatar = $googleUser->getAvatar();
            $google_id = $googleUser->getId();

            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                    'name' => $first_name . ' ' . $last_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'google_id' => $google_id,
                    'avatar' => $avatar,
                ]);
            }

            Auth::login($user);

            return redirect()->route('main')->with('success', 'Authorization successful!');
        }
        catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')->withErrors('Authorization error: incorrect state.');
        }
        catch (\Exception $e) {
            return redirect()->route('login')->withErrors('Authorization error: ' . $e->getMessage());
        }
    }
}
