<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;

class GoogleAuthController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Allow only Gmail accounts
        if (!str_ends_with($googleUser->email, '@gmail.com')) {
            return redirect()->route('admin.login.signIn')
                ->withErrors(['email' => 'Only Gmail accounts are allowed.']);
        }

        // Check if admin exists using google_id
        $admin = Admin::where('google_id', $googleUser->id)->first();

        if (!$admin) {

            // Check if email already exists
            $admin = Admin::where('email', $googleUser->email)->first();

            if ($admin) {

                // Link existing account with Google
                $admin->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar
                ]);

            } else {

                // Split name safely
                $names = explode(' ', $googleUser->name, 2);

                // Create new admin
                $admin = Admin::create([
                    'first_name'  => $names[0] ?? 'Admin',
                    'last_name'   => $names[1] ?? '',
                    'email'       => $googleUser->email,
                    'google_id'   => $googleUser->id,
                    'avatar'      => $googleUser->avatar,
                    'password'    => bcrypt(uniqid()),
                    'is_verified' => true
                ]);
            }
        }

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');
    }
}