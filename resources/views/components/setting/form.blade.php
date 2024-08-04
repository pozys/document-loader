<x-forms.entity>
    <h1 class="mb-5">{{ $title }}: {{ $setting?->name }}</h1>

    {{ html()->modelForm($setting ?? null, $method, $action)->open() }}
    {{ html()->hidden('user_id', $setting?->user_id ?? auth()->user()->id) }}

    <div class="flex flex-col">
        <div>
            {{ html()->label( __('setting.name'), 'setting')->class('font-black') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')->class('rounded border-gray-300 w-1/3')->required() }}
            @error('name')
            <x-forms.validation :$message />
            @enderror
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_type'), 'document_type')->class('font-black') }}
        </div>
        <div>
            {{ html()->select('document_type', $documentTypes)
            ->class('rounded border-gray-300 w-1/3')->required() }}
            @error('document_type')
            <x-forms.validation :$message />
            @enderror
        </div>
        <div class="mt-2">
            {{ html()->label( __('setting.document_format'), 'document_format')->class('font-black') }}
        </div>
        <div>
            {{ html()->select('document_format', $documentFormats)
            ->class('rounded border-gray-300 w-1/3')->required() }}
            @error('document_format')
            <x-forms.validation :$message />
            @enderror
        </div>

        <div class="w-full flex items-center">
            <div class="ml-auto">
                <a href="{{ route('settings.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    {{ __('setting.index.create') }}</a>
            </div>
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>{{ __('setting.form.setting.title') }}</th>
                    <th>{{ __('setting.form.value.title') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                $type=$setting?->document_type ?? $type;
                @endphp
                @foreach ($schemaElements as $name => $htmlType)
                <tr class="border-b border-dashed text-left">
                    <td>
                        <span class="font-black">{{ __("setting-properties.{$type->value}.{$name}")
                            }}</span>
                    </td>
                    <td>{{
                        html()->$htmlType("settings[{$name}][value]", $settings[$name] ?? null)->class('rounded
                        border-gray-300 w-1/3') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">
            {{ $submit }}
        </div>
    </div>
    {{ html()->closeModelForm() }}
</x-forms.entity>