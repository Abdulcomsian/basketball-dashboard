<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Traits\VerificationOtp;
use Illuminate\Http\Request;

class OtpConfirmationController extends Controller
{
    use VerificationOtp;

    public function index($username)
    {

        return view('auth.passwords.otp',compact('username'));
    }

    public function verification(OtpRequest $request)
    {        
        // check username with rest password record
        $data = $this->verifyUsername($request);

        if(!$data)
        {

            return back()->withErrors(['username' => trans('passwords.invalid_username_or_otp')]);
            
        }

        // verify otp
        $isOtpValid = $this->verifyOtp($request, $data);  // Call trait method
    
        if (!$isOtpValid) 
        {
            
            // OTP is invalid
            return back()->withErrors(['otp' => trans('passwords.invalid_otp')]);

        }

        // verify otp expiration
        $result = $this->verifyOtpExpiration($request, $data);  // Call trait method

        if(!$result)
        {
            
            return back()->with('error' , trans('passwords.otp_expired'));

        }
        else
        {
            
            return redirect()->route('reset.password',['username' => $data->username , 'otp' => $request->otp]);

        }

    }

}