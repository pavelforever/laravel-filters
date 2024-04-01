<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class AgeRangeFilter extends BaseFilter implements FilterContract
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
                    [Carbon::now()->subYears($this->requestValue('from')), Carbon::now()->subYears($this->requestValue('to'))]
                );
            });
        }
        return $query->whereBetween(
            $this->field(),
            [Carbon::now()->subYears($this->requestValue('from')), Carbon::now()->subYears($this->requestValue('to'))]
        );
    }
}
