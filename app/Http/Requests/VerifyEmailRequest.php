<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseEmailVerificationRequest;

class VerifyEmailRequest extends BaseEmailVerificationRequest
{
    // Custom request class extending EmailVerificationRequest
    // This ensures proper validation and authorization for email verification
}

