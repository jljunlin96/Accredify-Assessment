<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\API\DocumentFile\StoreRequest;
use App\Services\DocumentValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DocumentFileController extends ApiController
{
    public function __construct(private DocumentValidationService $documentValidationService)
    {
    }

    public function store(StoreRequest $request) : JsonResponse
    {
        $file = $request->file('file');
        $fileValidation = $this->documentValidationService->__invoke($file);

        return new JsonResponse([
            'data' => $fileValidation
        ], Response::HTTP_OK);

    }
}
