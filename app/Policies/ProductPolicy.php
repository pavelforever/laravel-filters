<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function generateDownloadLink(User $user, Product $product)
    {
        return $product->userHasPurchased($user)
            ? Response::allow()
            : Response::deny('You have not purchased this product.');
    }
}
