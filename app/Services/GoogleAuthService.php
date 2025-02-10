<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthService
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
                throw new \Exception('Google Error!');
            }

            $user = $this->findOrCreateUser($googleUser);

            Auth::login($user);

            return redirect()->route('main')->with('success', 'Authorization successful!');
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            throw new \Exception('Authorization error: incorrect state.');
        } catch (\Exception $e) {
            throw new \Exception('Authorization error: ' . $e->getMessage());
        }
    }

    private function findOrCreateUser($googleUser)
    {
        $email = $googleUser->getEmail();
        $first_name = $googleUser->getName();
        $last_name = $googleUser->user['family_name'];
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
        return $user;
    }
}
