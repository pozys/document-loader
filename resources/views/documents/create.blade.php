<x-forms.entity>
    <h1 class="mb-5">{{ __('document.create.title') }}</h1>
    {{ html()->form()->route('documents.check')->acceptsFiles()->open() }}
    <div>
        <div class="mt-2">
            {{ html()->label( __('document.setting_id'), 'setting_id') }}
        </div>
        {{ html()->select('setting_id', $userSettings)
        ->class('rounded border-gray-300 w-1/3')->required() }}
        @error('setting_id')
        <x-forms.validation :$message />
        @enderror
    </div>
    <div class="mt-2">
        {{ html()->file('file')->required() }}
    </div>
    <div class="mt-2">
        <x-forms.submit :text="__('document.check.submit')" />
    </div>
    {{ html()->form()->close() }}
</x-forms.entity>
