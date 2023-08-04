<?php

namespace App\Enums;

enum DocumentValidationStatus: string
{
    case InvalidRecipient = 'invalid_recipient';
    case InvalidIssuer = 'invalid_issuer';
    case InvalidSignature = 'invalid_signature';
    case Verified = 'verified';
}
