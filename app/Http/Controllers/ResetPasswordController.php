<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetOtp;
use App\Models\User;
use App\Traits\VerificationOtp;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    use VerificationOtp;
    public function index($username , $otp)
    {
        
        $user = User::whereHas('otp' , function ($query) use ($username){
            
            $query->where('username' , $username);

        })
        ->with('otp' , function ($query) use ($username){
            
            $query->where('username' , $username);

        })
        ->where('username',$username)->first();

        if(!$user)
        {
            
            return redirect()->route('login')->with('error' , $username . ' did not generate password request');

        }

        return view('auth.passwords.custom-reset',compact('user' , 'otp'));
        
    }

    public function reset(Request $request)
    {

        $request->validate($this->rules(), $this->validationErrorMessages());

        $this->credentials($request);

        // check username with rest password record
        $data = $this->verifyUsername($request);

        if(!$data)
        {

            return back()->withErrors(['username' => trans('passwords.username')]);
            
        }

        // verify otp
        $isOtpValid = $this->verifyOtp($request, $data);  // Call trait method

        if (!$isOtpValid) 
        {
            
            // OTP is invalid
            return back()->withErrors(['otp' => trans('passwords.mismatched_otp')]);

        }
        

        // verify otp expiration
        $result = $this->verifyOtpExpiration($request, $data);  // Call trait method

        if(!$result)
        {
            
            return back()->with('error' , trans('passwords.otp_expired'));

        }
        else
        {
            
            // update password
            $result = User::where('username' , $request->username)
            ->update([
                'password' => bcrypt($request->password)
            ]);

            if($result)
            {
                // delete otp
                PasswordResetOtp::where('username' , $request->username)->delete();

            }

            return redirect()->route('login')->with('message',trans('passwords.reset'));

        }
        
    }

    protected function rules()
    {
        return [
            'otp' => 'required',
            'username' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    protected function validationErrorMessages()
    {
        return [];
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'username', 'password', 'password_confirmation', 'otp'
        );
    }

}