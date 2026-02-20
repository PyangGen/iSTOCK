<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminVerificationMail;
use Illuminate\Validation\Rule;

class AdminAuthController extends Controller
{
  public function showCreate()
  {
    return view('admin.create.signUp'); // adjust path to your blade
  }

public function storeCreate(Request $request)
{
    $messages = [
        'password.regex' => 'Password must contains uppercase, numbers, and special characters.',
        'first_name.unique' => 'This first name and last name combination already exists.',
        // ✅ show this message when email is not Gmail or not valid format
        'email.email' => 'Please enter a valid email address.',
        'email.regex' => 'Please enter a valid email address.',
    ];

    $validated = $request->validate([
        'first_name' => [
            'required',
            'string',
            'max:30',
            Rule::unique('admins')->where(function ($query) use ($request) {
                return $query->where('last_name', $request->last_name);
            }),
        ],
        'last_name' => ['required', 'string', 'max:30'],

        // ✅ Gmail-only validation (must end with @gmail.com)
        'email' => [
            'required',
            'email:rfc,dns',
            'max:255',
            'regex:/^[^@\s]+@gmail\.com$/i',
            'unique:admins,email'
        ],

        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ], $messages);

    $verificationCode = rand(100000, 999999);

    session([
  'admin_register_data' => [
    'first_name' => $validated['first_name'],
    'last_name'  => $validated['last_name'],
    'email'      => $validated['email'],
    'password'   => Hash::make($validated['password']),
    'code'       => $verificationCode,
    'expires_at' => now()->addMinutes(5)->timestamp, // ✅ store epoch seconds
  ]
]);


    $this->sendVerificationEmail($validated['email'], $verificationCode);

    return redirect()->route('admin.create.verify-email')
        ->with('success', 'Verification code sent to your email.');
}


private function sendVerificationEmail($email, $code)
{
    Mail::to($email)->send(new AdminVerificationMail($email, $code));
}


public function showVerify()
{
    return view('admin.create.verify-email');
}

public function verifyEmail(Request $request)
{
    $request->validate([
        'code' => 'required'
    ]);

    $sessionData = session('admin_register_data');

    if (!$sessionData) {
        return redirect()->route('admin.create.signUp')
            ->withErrors(['email' => 'Session expired. Please register again.']);
    }

    // ✅ expired check
    if (time() > (int)$sessionData['expires_at']) {
        return back()->withErrors(['code' => 'Verification code is expired.']);
    }

    // ✅ code match
    if ($request->code == $sessionData['code']) {

        Admin::create([
            'first_name' => $sessionData['first_name'],
            'last_name'  => $sessionData['last_name'],
            'email'      => $sessionData['email'],
            'password'   => $sessionData['password'],
            'is_verified'=> true
        ]);

        session()->forget('admin_register_data');

        return redirect()->route('admin.create.signUp')
            ->with('success', 'Account verified and created successfully!');
    }

    return back()->withErrors(['code' => 'Invalid verification code.']);
}

public function resendCode()
{
    $data = session('admin_register_data');

    if (!$data) return redirect()->route('admin.create.signUp');

    $newCode = rand(100000, 999999);

    $data['code'] = $newCode;
    $data['expires_at'] = now()->addMinutes(5)->timestamp; // ✅ restart 5 min

    session(['admin_register_data' => $data]);

    $this->sendVerificationEmail($data['email'], $newCode);

    return back()->with('success', 'Verification code resent.');
}



  public function showSignIn()
{
    return view('admin.login.signIn');
}

public function signIn(Request $request)
{
    $request->validate([
        'email' => ['required', 'email:rfc,dns'],
        'password' => ['required'],
    ], [
        'email.required' => 'This field is required.',
        'password.required' => 'This field is required.',
        'email.email' => 'Please enter a valid email address.',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    // Email not found -> error only on email
    if (!$admin) {
        return back()
            ->withErrors(['email' => 'Email not found.'])
            ->withInput($request->only('email'));
    }

    // Email exists but password wrong -> error only on password
    if (!Hash::check($request->password, $admin->password)) {
        return back()
            ->withErrors(['password' => 'Invalid credentials.'])
            ->withInput($request->only('email'));
    }

    Auth::guard('admin')->login($admin);
    $request->session()->regenerate();

    return redirect()->route('admin.dashboard');
}
public function logout(Request $request)
{
    $admin = Auth::guard('admin')->user();

    // Log logout attempt
    Log::info('Admin logout', [
        'email' => $admin?->email,
        'ip' => $request->ip(),
    ]);

    Auth::guard('admin')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login.signIn');
}

public function sendForgotOtp(Request $request)
{
    $request->validate([
        'email' => ['required', 'email:rfc,dns'],
    ], [
        'email.required' => 'This field is required.',
        'email.email' => 'Please enter a valid email address.',
    ]);

    $admin = Admin::where('email', $request->email)->first();

    if (!$admin) {
        return back()
            ->withErrors(['email' => 'Email not found.'])
            ->withInput();
    }

    $code = rand(100000, 999999);

    // ✅ STORE OTP IN DATABASE
    $admin->verification_code = $code;
    $admin->save();

    // store only email + expiry in session
    session([
        'admin_forgot_data' => [
            'email' => $admin->email,
            'expires_at' => now()->addMinutes(5)->timestamp,
        ]
    ]);

    $this->sendVerificationEmail($admin->email, $code);

    return redirect()->route('admin.login.otp-sent');
}

public function verifyForgotOtp(Request $request)
{
    $request->validate([
        'code' => 'required'
    ]);

    $data = session('admin_forgot_data');

    if (!$data) {
        return redirect()->route('admin.login.eemail')
            ->withErrors(['email' => 'Session expired. Please try again.']);
    }

    if (time() > (int)$data['expires_at']) {
        return back()->withErrors(['code' => 'Verification code is expired.']);
    }

    $admin = Admin::where('email', $data['email'])->first();

    if (!$admin || $admin->verification_code != $request->code) {
        return back()->withErrors(['code' => 'Invalid verification code.']);
    }

    // ✅ OTP CORRECT → CLEAR CODE
    $admin->verification_code = null;
    $admin->save();

    return redirect()->route('admin.login.reset-password');
}
public function resendForgotOtp()
{
    $data = session('admin_forgot_data');

    if (!$data) {
        return redirect()->route('admin.login.eemail');
    }

    $admin = Admin::where('email', $data['email'])->first();

    if (!$admin) {
        return redirect()->route('admin.login.eemail');
    }

    $newCode = rand(100000, 999999);

    // ✅ Update DB
    $admin->verification_code = $newCode;
    $admin->save();

    // update session expiry only
    session([
        'admin_forgot_data' => [
            'email' => $admin->email,
            'expires_at' => now()->addMinutes(5)->timestamp,
        ]
    ]);

    $this->sendVerificationEmail($admin->email, $newCode);

    return redirect()->route('admin.login.otp-sent');
}

// Show reset password page
public function showResetPassword()
{
    $data = session('admin_forgot_data');
    if (!$data) {
        return redirect()->route('admin.login.eemail')
            ->withErrors(['email' => 'Session expired. Please try again.']);
    }

    return view('admin.login.reset-password', [
        'email' => $data['email']
    ]);
}

// Update password
public function updatePassword(Request $request)
{
    $data = session('admin_forgot_data');
    if (!$data) {
        return redirect()->route('admin.login.eemail')
            ->withErrors(['email' => 'Session expired. Please try again.']);
    }

    $request->validate([
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed', // must match password_confirmation
            'regex:/[A-Z]/',        // at least one uppercase
            'regex:/[0-9]/',        // at least one number
            'regex:/[@$!%*#?&]/',   // at least one special character
        ]
    ], [
        'password.required' => 'This field is required.',
        'password.confirmed' => 'Password confirmation does not match.',
        'password.regex' => 'Password musts contain uppercase, number, and special character.',
        'password.min' => 'Password must be at least 8 characters.',
    ]);

    // Update admin password
    $admin = Admin::where('email', $data['email'])->first();
    $admin->password = Hash::make($request->password);
    $admin->save();

    // Clear session
    session()->forget('admin_forgot_data');

    return redirect()->route('admin.login.signIn')
        ->with('success', 'Password updated successfully. You can now login.');
}
}

