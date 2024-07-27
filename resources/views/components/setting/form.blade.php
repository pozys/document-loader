<x-forms.entity>
    <h1 class="mb-5">{{ $title }}</h1>

    {{ html()->modelForm($setting ?? null, $method, $action)->open() }}
    {{ html()->hidden('user_id', $setting->user_id ?? auth()->user()->id) }}
    <div class="flex flex-col">
        <div>
            {{ html()->label( __('setting.name'), 'setting') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')->class('rounded border-gray-300 w-1/3') }}
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_type'), 'document_type') }}
        </div>
        <div>
            {{ html()->select('document_type', $documentTypes)
            ->class('rounded border-gray-300 w-1/3') }}
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_format'), 'document_format') }}
        </div>
        <div>
            {{ html()->select('document_format', $documentFormats)
            ->class('rounded border-gray-300 w-1/3') }}
        </div>
        <div>
            @foreach ($settingValues as $settingName => $settingValue)
            <div>
                <p><span class="font-black">{{ __($settingName) }}:</span> {{
                    html()->number("settings[{$settingName}][value]", $settingValue->getValue())->class('rounded
                    border-gray-300 w-1/3') }}
                </p>
            </div>
            @endforeach
        </div>
        <div class="mt-2">
            {{ $submit }}
        </div>
    </div>
    {{ html()->closeModelForm() }}
</x-forms.entity>