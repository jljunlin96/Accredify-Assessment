<?php

namespace App\Services;


use App\Enums\DocumentValidationStatus;
use App\Models\DocumentAnalysis;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DocumentValidationService
{
    public function __invoke(UploadedFile|array|null $file)
    {
        $fileValidation = $this->verifyDocument($file);
        DocumentAnalysis::create([
            'user_id' => Auth::id(),
            'verification_result' => $fileValidation['result'],
            'file_type' => $file->getMimeType(),
            'timestamp' => now()
        ]);

        return $fileValidation;
    }

    public function verifyDocument(UploadedFile|array|null $file): array
    {
        $fileContent = $file->getContent();
        $fileContent = json_decode($fileContent, true);
        $data = $fileContent['data'];
        $issuerName = $data['issuer']['name'] ?? null;

        //Check if the document has a recipient and if the recipient has a name and email
        //In the future, we can check the name and email is not empty
        if (!isset($data['recipient']['name']) || !isset($data['recipient']['email'])) {
            return [
                'result' => DocumentValidationStatus::InvalidRecipient,
                'issuer' => $issuerName,
            ];
        }

        $checkIssuer = false;

        if (isset($data['issuer']) || $issuerName || isset($data['issuer']['identityProof'])) {
            $name = $data['issuer']['identityProof']['location'];
            $identifyProofKey = $data['issuer']['identityProof']['key'];
            $checkIssuer = $this->verifyDnsResponse($identifyProofKey, $name);
        }

        if (!$checkIssuer) {
            return [
                'result' => DocumentValidationStatus::InvalidIssuer,
                'issuer' => $issuerName,
            ];
        }

        //List each property's path from the data object and associate its value
        $convertedArray = $this->convertArrayToObjectPath($data);

        foreach ($convertedArray as $key => $value) {
            $value = "{\"{$key}\":\"{$value}\"}";
            $hashes[] = hash('sha256', $value);
        }

        //Sort all the hashes alphabetically and hash them all together
        sort($hashes);
        $prettierHashes = json_encode($hashes);
        $hash = hash('sha256', $prettierHashes);
        $targetHash = $fileContent['signature']['targetHash'] ?? '';

        if($targetHash !== $hash){
            return [
                'result' => DocumentValidationStatus::InvalidSignature,
                'issuer' => $issuerName,
            ];
        }

        return [
            'result' => DocumentValidationStatus::Verified,
            'issuer' => $issuerName,
        ];
    }

    public function verifyDnsResponse(string $identifyProofKey, string $name, string $type = 'TXT'): bool
    {
        //Get the TXT record from the DNS server
        $response = Http::get('https://dns.google/resolve', [
            'name' => $name,
            'type' => $type,
        ]);

        $dnsIdentityProofs = $response['Answer'] ?? [];
        foreach ($dnsIdentityProofs as $dnsIdentityProof) {
            //Check if the TXT record contains the identity proof key and return true if it does
            if (strpos($dnsIdentityProof['data'],$identifyProofKey)) {
                return true;
            }
        }
        return false;
    }

    public function convertArrayToObjectPath(array $array, string $prefix = ''): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            //If the value is an array, recursively call this function to get the value of the nested array
            if (is_array($value)) {
                $result = array_merge($result, $this->convertArrayToObjectPath($value, $prefix . $key . '.'));
            } else {
                $result[$prefix . $key] = $value;
            }
        }
        return $result;
    }
}
