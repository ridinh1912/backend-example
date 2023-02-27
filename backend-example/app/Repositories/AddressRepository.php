<?php

namespace App\Repositories;

use App\Models\Address;

class AddressRepository extends AbstractBaseRepository
{
    const PER_PAGE = 15;
    public function __construct(public Address $model)
    {
    }
}
