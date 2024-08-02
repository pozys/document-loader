<x-setting.form method='POST' :action="route('settings.store')" :title="__('setting.create.title')" :$documentTypes
    :$documentFormats :$schemaElements :$type :setting=null>
    <x-slot:submit>
        <x-forms.submit :text="__('setting.create.submit')" />
        </x-slot>
</x-setting.form>