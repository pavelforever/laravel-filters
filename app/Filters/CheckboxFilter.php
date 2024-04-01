<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;

class CheckboxFilter extends BaseFilter implements FilterContract
{
    protected static string $view = 'checkbox';
}
