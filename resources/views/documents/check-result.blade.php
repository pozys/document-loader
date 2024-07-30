<x-app-layout>
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">{{ __('document.check-result.title') }}</h1>

                @php
                $summary = $response->summary;
                @endphp

                <div class="mt-2">
                    <p>{{ html()->span( __('setting-properties.UTD.number'))->class('font-black') }}:
                        {{ html()->input()->value($summary['number'])->class('rounded border-gray-300
                        w-1/4')->isReadonly() }}
                        {{ html()->span( __('setting-properties.UTD.date'))->class('font-black') }}:
                        {{ html()->input()->value($summary['date'])->class('rounded border-gray-300
                        w-1/4')->isReadonly() }}
                    </p>
                </div>
                <div class="mt-2">
                    <table class="mt-4">
                        <thead class="border-b-2 border-solid border-black text-center">
                            <tr>
                                <th>{{ __('setting-properties.UTD.amount') }}</th>
                                <th>{{ __('setting-properties.UTD.vat') }}</th>
                                <th>{{ __('setting-properties.UTD.amount_with_vat') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" style="text-align:center">{{ __('document.check-result.UTD.as_is.title')
                                    }}
                                </td>
                            </tr>
                            <tr class="border-b border-dashed text-left">
                                <td>{{ html()->input('number')->value($summary['amount_as_is'])->isReadonly() }}</td>
                                <td>{{ html()->input('number')->value($summary['vat_as_is'])->isReadonly() }}</td>
                                <td>{{ html()->input('number')->value($summary['amount_with_vat_as_is'])->isReadonly()}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:center">{{
                                    __('document.check-result.UTD.as_to_be.title')
                                    }}</td>
                            </tr>
                            <tr class="border-b border-dashed text-left">
                                <td>{{ html()->input('number')->value($summary['amount_as_to_be'])->isReadonly() }}</td>
                                <td>{{ html()->input('number')->value($summary['vat_as_to_be'])->isReadonly() }}</td>
                                <td>{{
                                    html()->input('number')->value($summary['amount_with_vat_as_to_be'])->isReadonly()
                                    }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:center">{{ __('document.check-result.UTD.diff.title')
                                    }}
                                </td>
                            </tr>
                            <tr class="border-b border-dashed text-left">
                                <td>{{ html()->input('number')->value($summary['amount_diff'])->isReadonly() }}</td>
                                <td>{{ html()->input('number')->value($summary['vat_diff'])->isReadonly() }}</td>
                                <td>{{ html()->input('number')->value($summary['amount_with_vat_diff'])->isReadonly() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-2">
                        <p>{{ html()->span( __('document.check-result.UTD.goods_count'))->class('font-black') }}:
                            {{ html()->input()->value($summary['goods_count'])->class('rounded border-gray-300
                            w-1/4')->isReadonly()
                            }}
                        </p>
                    </div>

                    {{ html()->form()->route('documents.send', ['id'=>$response->id])->open() }}
                    <div class="mt-2">
                        <x-forms.submit :text="__('document.check-result.submit')" />
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>