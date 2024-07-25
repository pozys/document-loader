<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Document;

use App\Application\DTO\CheckDocumentRequest;
use App\Application\UseCases\CheckDocumentUseCase;
use App\Domain\Models\Setting\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckDocumentController
{
    public function __construct(private CheckDocumentUseCase $useCase)
    {
    }

    public function checkDocument(Request $request): JsonResponse
    {
        $setting = Setting::findOrFail($request->setting_id);
        $path = Storage::path($request->path);
        $checkDocumentRequest = new CheckDocumentRequest($setting, $path);
        $result = $this->useCase->execute($checkDocumentRequest);

        return response()->json(compact('result'));
    }
}
