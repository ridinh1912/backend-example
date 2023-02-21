<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository extends AbstractBaseRepository
{
    public function __construct(public Address $model)
    {
    }
}
