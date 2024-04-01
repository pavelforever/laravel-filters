<form class="hidden lg:block" id="filter-submission-form" method="get">
    <div>
        <div class="accordion" id="filtersAccordion">
            @foreach($filters as $filter)
                <div x-data="{ open: {{ $filter->requestValue() ? 'true' : 'false' }} }" class="accordion-item-{{$loop->iteration}} border-b border-gray-200 py-6" style="margin-left: 15px">
                    <h3 class="-my-3">
                        <button @click="open = !open" type="button" class="accordion-button py-3 bg-white w-full flex items-center justify-between text-sm text-gray-200" aria-controls="{{ $filter->id() }}" :aria-expanded="open ? 'true' : 'false'">   
                            <label for="{{ $filter->id() }}" class="font-medium text-gray-900"> 
                                {{ $filter->label() }}
                            </label>
                            <span class="ml-6 flex items-center">
                                <svg x-show="!open" data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                </svg>
                            </span>
                        </button>
                    </h3>
                    <div x-show="open" class="accordion-collapse" id="{{ $filter->id() }}">
                        <div class="accordion-body pt-6">
                            <div class="space-y-4">
                                {!! $filter->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <button type="submit" style="margin-left: 15px;" class="tw-mt-10 tw-w-full tw-bg-indigo-600 tw-border tw-border-transparent tw-rounded-md tw-py-3 tw-px-8 tw-flex tw-items-center tw-justify-center">Поиск</button>
</form>
