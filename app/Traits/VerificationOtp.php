<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

trait VerificationOtp
{

  public function verifyUsername(Request $request)
  {
    $result = PasswordResetOtp::where('username', $request->username)->first();
    
    if (!$result) {
        return false;
    }

    return $result;
    
  }

  public function verifyOtpExpiration(Request $request, $result)
  {
    $now = now(); // Current time
    $expiration = Carbon::parse($result->created_at)->addMinutes(60); // Add 60 minutes to creation time

    if (!$expiration->isAfter($now)) {
      return false;
    }

    return true;  // Return true if not expired
  }

  public function verifyOtp(Request $request, $result)
  {
    $hashedOtp = $result->otp;
    $enteredOtp = $request->otp;

    if (Hash::check($enteredOtp, $hashedOtp)) {
      return true;  // Return true if OTP matches
    }

    return false;
  }
}