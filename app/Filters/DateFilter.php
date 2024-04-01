<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;

class DateFilter extends BaseFilter implements FilterContract
{
    protected static string $view = 'date';
    protected static string $type = 'date';
}
