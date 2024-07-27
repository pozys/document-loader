<x-forms.entity>
    <h2 class="mb-5">
        {{ __('setting.show.title_prefix') . ": $setting->name" }}
    </h2>
    <p><span class="font-black">{{ __('setting.name') }}:</span> {{ $setting->name }}</p>
    <p><span class="font-black">{{ __('setting.document_type') }}:</span> {{ $setting->document_type }}</p>
    <p><span class="font-black">{{ __('setting.document_format') }}:</span> {{ $setting->document_format }}</p>
    <div>
        @foreach ($setting->settings->getSettings() as $settingName => $settingValue)
        <div>
            <p><span class="font-black">{{ __($settingName) }}:</span> {{ $settingValue->getValue() }}
            </p>
        </div>
        @endforeach
    </div>
</x-forms.entity>