<input 
    id="{{$filter->id()}}"
    name="{{ $filter->name() }}"
    value="{{ $filter->requestValue() ?? ''}}"
    type="{{ $filter->type() }}"
    class="h-4 w-4 border-gray-600 rounded text-indigo-600 focus:ring-indigo-500"
/>