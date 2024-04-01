<input 
    id="{{$filter->id()}}"
    name="{{ $filter->name() }}"
    value="{{ $filter->requestValue() ?? ''}}"
    type="{{ $filter->type() }}"
/>