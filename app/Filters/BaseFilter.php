<?php
namespace App\Filters;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class BaseFilter 
{
    protected array $attributes = [];
    protected bool $multiple = false;
    protected ?Closure $customQuery = null;
    protected string $field;
    protected string $label;
    protected ?string $relatedField;
    protected array $values = [];

    protected static string $type = 'text';
    protected static string $view = 'input';

    public function __construct(string $label, string $field, string|null $relatedField = null, array $values = [])
    {
        $this->setLabel($label);
        $this->setField($field);
        $this->setRelatedField($relatedField);
        $this->setValues($values);
    }

    public static function make(...$args) : static 
    {
        return new static(...$args);
    }

    // Attribute Methods
    public function attribute(string $name): string 
    {
        return $this->attributes[$name] ?? '';
    }

    public function attributes(array $attributes): static
    {
        $this->attributes = $attributes;
        return $this;
    }

    // Custom Query Methods
    public function customQuery(?Closure $customQuery): static 
    {
        $this->customQuery = $customQuery;
        return $this;
    }

    public function getCustomQuery(): ?Closure
    {
        return $this->customQuery;
    }

    public function hasCustomQuery(): bool 
    {
        return !is_null($this->customQuery);
    }

    // Field Methods
    public function field(): string 
    {
        return $this->field;
    }

    public function setField(string $field): static 
    {
        $this->field = $field;
        return $this;
    }

    // Label Methods
    public function label(): string 
    {
        return str($this->label)->ucfirst();
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    // Multiple Methods
    public function isMultiple(): bool 
    {
        return $this->multiple;
    }

    public function multiple(): static 
    {
        $this->multiple = true;
        return $this;
    }

    // Request Value Methods
    public function requestValue(?string $param = null): string|array|null
    {   
        $pathDot = (string) str('filters')
            ->append(".{$this->field()}")
            ->when($param,fn(Stringable $str) => $str->append(".$param"));
        return request($pathDot);
    }

    // Render Method
    public function render(): Factory|View|Application
    {
        return view('filters.' . $this->view(), ['filter' => $this]);
    }

    // Related Field Methods
    public function relatedField(): ?string
    {
        return $this->relatedField;
    }

    public function setRelatedField(?string $relatedField): static 
    {
        $this->relatedField = $relatedField;
        return $this;
    }

    // Type Method
    public function type(): string 
    {
        return static::$type;
    }

    // Values Methods
    public function hasValues(): bool 
    {
        return $this->values()->isNotEmpty();
    }

    public function setValues(array $values): static
    {
        $this->values = $values;
        return $this;
    }

    public function values(): Collection 
    {
        return collect($this->values);
    }

    // View Method
    public function view(): string 
    {
        return static::$view;
    }

    // ID Method
    /**
     * @return string // $value == null ? filters_price : filters_price_$value;
     */
    public function id(?string $value = null): string
    {
        return (string) str($this->field())
            ->snake()
            ->prepend('filters_')
            ->when($value, fn(Stringable $str) => $str->append("_$value"));
    }

    // Name Method
    /**
     * @return string // (isMultiple()) ? filters[price][] : filters[price] 
     */
    public function name(): string
    {
        return (string) str("filters[{$this->field()}]")
            ->when($this->isMultiple(),fn(Stringable $str) => $str->append("[]"));
    }

    // Apply Method
    public function apply(Builder $query): Builder  
    {   
        if (is_null($this->requestValue()) || (is_array($this->requestValue()) && empty($this->requestValue()))) {
            return $query;
        }

        if($this->hasCustomQuery()) {
            $query = $query->where($this->getCustomQuery());
        } elseif($this->relatedField()){
            $query = $query->whereHas($this->field(), function (Builder $q){
                return is_array($this->requestValue())
                    ? $q->whereIn($this->relatedField(), $this->requestValue())
                    : $q->where($this->relatedField(), '=', $this->requestValue());
            });
        } elseif(is_array($this->requestValue())){
            $query = $query->whereIn($this->field(), $this->requestValue());
        } else {
            $query = $query->where($this->field(), '=', $this->requestValue());
        }

        return $query;
    }
}
