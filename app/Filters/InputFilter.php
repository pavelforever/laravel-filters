<?php 

namespace App\Filters;

use App\Contracts\Filters\FilterContract;

class InputFilter extends BaseFilter implements FilterContract
{
    protected static string $view = 'input';
}
