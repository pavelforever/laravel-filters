@if($filter->hasValues())
    @foreach($filter->values() as $value => $label)
        @if($filter->isMultiple())
            <div class="d-flex align-items-center">
                <input 
                    id="{{$filter->id($value)}}"
                    name="{{$filter->name()}}"
                    value="{{$value}}"
                    type="checkbox"
                    @checked($filter->requestValue() && in_array($value,$filter->requestValue())) 
                    class="form-check-input me-1"
                />
                <label for="{{$filter->id($value) }}" class="form-check-label">
                    {{ $label }}
                </label> 
            </div>
        @else    
            @if($loop->first)
            <div class="d-flex align-items-center">
            
                <input 
                    id="{{$filter->id('default')}}"
                    name="{{$filter->name()}}"
                    value=""
                    type="radio"
                    @checked($filter->requestValue() == null)
                    class="form-check-input me-1"
                />
                <label for="{{$filter->id('default') }}" class="form-check-label">
                    {{ 'Default' }}
                </label> 
            </div>
            @endif
            <div class="d-flex align-items-center">
            
            <input 
                id="{{$filter->id($value)}}"
                name="{{$filter->name()}}"
                value="{{$value}}"
                type="radio"
                @checked($filter->requestValue() && $filter->requestValue() == $value) 
                class="form-check-input me-1"
            />
            <label for="{{$filter->id($value) }}" class="form-check-label">
                {{ $label }}
            </label> 
        </div>
        @endif 

    @endforeach
@else
    <input 
        id="{{$filter->id() }}"
        name="{{$filter->name()}}"
        value="1"
        @checked($filter->requestValue())
        class="form-check-input me-1"
    />
    <label for="{{$filter->id() }}" class="form-check-label">
    </label>    
@endif
