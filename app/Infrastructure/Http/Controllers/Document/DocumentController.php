<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Document;

use App\Application\UseCases\SendDocumentUseCase;
use App\Domain\Models\Interfaces\DocumentRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DocumentController
{
    public function __construct(
        private readonly DocumentRepositoryInterface $repository,
        private readonly SendDocumentUseCase $sendDocumentUseCase
    ) {
    }

    public function index(): View
    {
        $documents = $this->repository->all();

        return view('documents.index', compact('documents'));
    }

    public function create(): View
    {
        $userSettings = Setting::where('user_id', Auth::id())->get()->pluck('name', 'id')->sortKeys()->all();

        return view('documents.create', compact('userSettings'));
    }

    public function send(int $id): RedirectResponse
    {
        $this->sendDocumentUseCase->execute($id);

        return redirect()->route('documents.index');
    }
}
