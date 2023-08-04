<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class DocumentVerifiedTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_document_verified(): void
    {
        $filePath = storage_path('app/public/document_verified.json');
        $file = new UploadedFile($filePath, 'test.json', 'application/json', null, true);

        $bearerToken = User::all()->random()->createToken('testApi')->plainTextToken;
        $response = $this->withHeaders([
            'X-Header' => 'Value',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $bearerToken,
        ])->post('/api/v1/documents/files/store', ['file' =>$file]);

        PersonalAccessToken::where('name', 'testApi')->delete();
        dump($response->getContent());
        $response->assertStatus(200);
    }
}
