<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;

class SelectFilter extends BaseFilter implements FilterContract
{
    protected static string $view = 'select';
}
