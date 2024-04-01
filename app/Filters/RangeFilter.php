<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class RangeFilter extends BaseFilter implements FilterContract
{
    protected static string $view = 'range';

    public function apply(Builder $query): Builder
    {
        if(is_null($this->requestValue())){
            return $query;
        }

        if($this->relatedField()){
            return $query->whereHas($this->field(), function (Builder $q){
                $q->whereBetween(
                    $this->relatedField(),
                    [$this->requestValue('from'), $this->requestValue('to')]
                );
            });
        }
        return $query->whereBetween(
            $this->field(),
            [$this->requestValue('from'), $this->requestValue('to')]
        );
    }
}
