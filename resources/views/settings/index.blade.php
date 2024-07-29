<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('setting.index.title') }}</h1>

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
                            <th>{{ __('setting.name') }}</th>
                            <th>{{ __('setting.document_type') }}</th>
                            <th>{{ __('setting.document_format') }}</th>
                            <th>{{ __('setting.created_at') }}</th>
                            <th>{{ __('setting.index.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                        <tr class="border-b border-dashed text-left">
                            <td>
                                <a class="text-blue-600 hover:text-blue-900"
                                    href="{{ route('settings.show', $setting) }}">
                                    {{ $setting->name }}
                                </a>
                            </td>
                            <td>{{ $setting->document_type->value }}</td>
                            <td>{{ $setting->document_format->value }}</td>
                            <td>{{ $setting->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('settings.edit', $setting) }}"
                                    class="text-blue-600 hover:text-blue-900">
                                    {{ __('setting.index.update') }} </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-app-layout>
