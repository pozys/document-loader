<x-forms.entity>
    <h1 class="mb-5">{{ $title }}</h1>

    {{ html()->modelForm($setting ?? null, $method, $action)->open() }}
    {{ html()->hidden('user_id', $setting?->user_id ?? auth()->user()->id) }}
    <div class="flex flex-col">
        <div>
            {{ html()->label( __('setting.name'), 'setting') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')->class('rounded border-gray-300 w-1/3')->required() }}
            @error('name')
            <x-forms.validation :$message />
            @enderror
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_type'), 'document_type') }}
        </div>
        <div>
            {{ html()->select('document_type', $documentTypes)
            ->class('rounded border-gray-300 w-1/3')->required() }}
            @error('document_type')
            <x-forms.validation :$message />
            @enderror
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_format'), 'document_format') }}
        </div>
        <div>
            {{ html()->select('document_format', $documentFormats)
            ->class('rounded border-gray-300 w-1/3')->required() }}
            @error('document_format')
            <x-forms.validation :$message />
            @enderror
        </div>
        <div>
            @php
            $type=$setting?->document_type ?? $type;
            @endphp
            @foreach ($schemaElements as $name => $htmlType)
            <div class="mt-2">
                <p><span class="font-black">{{ __("setting-properties.{$type->value}.{$name}")
                        }}:</span> {{
                    html()->$htmlType("settings[{$name}][value]", $settings[$name] ?? null)->class('rounded
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
