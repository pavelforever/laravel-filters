<?php 

namespace App\Contracts\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    /**
     * Apply the filter to the given query builder.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function apply(Builder $query): Builder;

    /**
     * Render the filter view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render();
    /**
     * initializate and returns instance of BaseFilter class
     *
     * @param  string $label 
     * @param string $field
     * @param ?string relatedField
     * @param array $values
     * @return BaseFilter
     */
    public static function make(string $label, string $field, ?string $relatedField = null, array $values = []): static;

}
