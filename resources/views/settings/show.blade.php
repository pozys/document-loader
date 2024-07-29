<x-forms.entity>
    <h2 class="mb-5">
        {{ __('setting.show.title') . ": $setting->name" }}
    </h2>
    <p><span class="font-black">{{ __('setting.name') }}:</span> {{ $setting->name }}</p>
    <p><span class="font-black">{{ __('setting.document_type') }}:</span> {{
        __("enums.document_types.{$setting->document_type->value}")}}</p>
    <p><span class="font-black">{{ __('setting.document_format') }}:</span> {{
        __("enums.document_formats.{$setting->document_format->value}") }}</p>
    <div>
        @foreach ($setting->settings->getSettings() as $settingName => $settingValue)
        <div>
            <p><span class="font-black">{{ __("setting-properties.{$setting->document_type->value}.{$settingName}")
                    }}:</span> {{
                $settingValue->getValue() }}
            </p>
        </div>
        @endforeach
    </div>
</x-forms.entity>
