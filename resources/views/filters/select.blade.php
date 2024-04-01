<select name="{{ $filter->name() }}" id="{{ $filter->id() }}" @if($filter->isMultiple()) multiple @endif>
    @foreach($filter->values() as $value => $label)
        <option
        @selected($filter->requestValue() && in_array($value, $filter->requestValue()))
        @else 
        @selected($filter->requestValue() == $value)
        @endif
        value={{ $value }}
        >
            {{ $label }}
        </option>
    @endforeach
</select>