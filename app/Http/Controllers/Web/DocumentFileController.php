<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\DocumentFile\StoreRequest;
use App\Models\DocumentAnalysis;
use App\Services\DocumentValidationService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DocumentFileController extends Controller
{

    public function __construct(private DocumentValidationService $documentValidationService)
    {
    }

    public function create() : Application|Factory|View|\Illuminate\Foundation\Application
    {
        return view('document-file.create');
    }

    public function store(StoreRequest $request) : Application|Factory|View|\Illuminate\Foundation\Application | JsonResponse
    {
        $file = $request->file('file');
        $fileValidation = $this->documentValidationService->__invoke($file);

        if($request->ajax() | $request->wantsJson()){
            return new JsonResponse([
                'data' => $fileValidation
            ], Response::HTTP_OK);
        }
        return view('document-file.create');
    }
}
