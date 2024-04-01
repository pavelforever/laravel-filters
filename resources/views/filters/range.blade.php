
<div class="range_container"  x-data="range_{{ $filter->id() }}()" x-init="mintrigger(); maxtrigger()">
    <div class="sliders_control">
       <input id="fromSlider" type="range"
            step="{{ $filter->attribute('step') ?? 1 }}"
            x-bind:min="min" x-bind:max="max"
            x-on:input="mintrigger"
            x-model="minValue"
       />
       <input id="toSlider" type="range"
            step="{{ $filter->attribute('step') ?? 1 }}"
            x-bind:min="min" x-bind:max="max"
            x-on:input="maxtrigger"
            x-model="maxValue"

       />
    </div>
    <div class="form_control">
      <div class="form_control_container">
          <div class="form_control_container__time">Min</div>
          <input name="{{ $filter->name() }}[from]" class="form_control_container__time__input" type="text" maxlength="5" x-on:input="mintrigger" x-model="minValue"/>
        </div>
        <div class="form_control_container">
          <div class="form_control_container__time">Max</div>
          <input class="form_control_container__time__input" name="{{ $filter->name() }}[to]" type="text" maxlength="5" x-on:input="maxtrigger" x-model="maxValue"/>
        </div>
    </div>
</div>


<script>
    function range_{{ $filter->id() }}() {
        return {
            minValue: parseInt('{{ $filter->requestValue()['from'] ?? $filter->attribute('min') ?? 0 }}'),
            maxValue: parseInt('{{ $filter->requestValue()['to'] ?? $filter->attribute('max') ?? 1000 }}'),
            min: parseInt('{{ $filter->attribute('min') ?? 0 }}'),
            max: parseInt('{{ $filter->attribute('max')+$filter->attribute('step') ?? 1000 }}'),
            step: parseInt('{{ $filter->attribute('step') ?? 1 }}'),
            minthumb: 0,
            maxthumb: 0,
            
            mintrigger() {
                this.minValue = Math.min(this.minValue, this.maxValue - this.step);
                this.minthumb = 100 - (((this.minValue - this.min) / (this.max - this.min)) * 100);
            },
            maxtrigger() {
                this.maxValue = Math.max(this.maxValue, this.minValue + this.step);
                this.maxthumb = 100 - (((this.maxValue - this.min) / (this.max - this.min)) * 100);
            },
        }
    }
</script>

<style>
    .range_container {
  display: flex;
  flex-direction: column;
  width: 80%;
  margin: 100px auto;
}

.sliders_control {
  position: relative;
  min-height: 50px;
}

.form_control {
  position: relative;
  display: flex;
  justify-content: space-between;
  font-size: 24px;
  color: #635a5a;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;
}

input[type=range]::-moz-range-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;  
}

input[type=range]::-webkit-slider-thumb:hover {
  background: #f7f7f7;
}

input[type=range]::-webkit-slider-thumb:active {
  box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
  -webkit-box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
}

input[type="text"] {
  color: #8a8383;
  width: 100px;
  height: 30px;
  font-size: 20px;
  border: none;
}

input[type=text]::-webkit-inner-spin-button, 
input[type=text]::-webkit-outer-spin-button {  
   opacity: 1;
}

input[type="range"] {
  -webkit-appearance: none; 
  appearance: none;
  height: 2px;
  width: 100%;
  position: absolute;
  background-color: #C6C6C6;
  pointer-events: none;
}

#fromSlider {
  height: 0;
  z-index: 1;
}
</style>
