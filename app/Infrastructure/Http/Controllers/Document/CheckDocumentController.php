<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Document;

use App\Application\DTO\CheckDocumentRequest;
use App\Application\UseCases\CheckDocumentUseCase;
use App\Domain\Interfaces\SchemaRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use App\Infrastructure\Utils\SpreadsheetProcessor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\Support\Facades\App;

class CheckDocumentController
{
    public function __construct(
        private readonly SchemaRepositoryInterface $schemaProvider,
    ) {
    }

    public function checkDocument(Request $request): RedirectResponse
    {
        $setting = Setting::findOrFail($request->setting_id);
        $path = $request->file->path();
        $documentSchema = $this->schemaProvider->getByMeta($setting->document_type, $setting->document_format);
        $checkDocumentRequest = new CheckDocumentRequest($path, $setting, $documentSchema);
        $useCase = App::makeWith(CheckDocumentUseCase::class, ['processor' => app(SpreadsheetProcessor::class)]);
        $response = $useCase->execute($checkDocumentRequest);

        return redirect()->route('documents.check-result')->with(compact('response'));
    }

    public function checkResult(Request $request): View
    {
        $request->session()->keep(['response']);
        $response = session('response');

        return view('documents.check-result', compact('response'));
    }
}
