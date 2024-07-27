<x-setting.form method='PUT' :action="route('settings.update', $setting)" :title="__('setting.edit.title')" :$setting
    :$documentTypes :$documentFormats :$settings :$schemaElements>
    <x-slot:submit>
        <x-forms.submit :text="__('setting.edit.submit')" />
        </x-slot>
</x-setting.form>
