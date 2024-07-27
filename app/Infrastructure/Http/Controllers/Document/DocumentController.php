<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controllers\Document;

use App\Domain\Models\Interfaces\DocumentRepositoryInterface;
use App\Domain\Models\Setting\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DocumentController
{
    public function __construct(
        private readonly DocumentRepositoryInterface $repository,
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
}
