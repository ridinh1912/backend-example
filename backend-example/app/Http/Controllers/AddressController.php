<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\HasCrud;
use App\Http\Requests\CreateAddressRequest;
use App\Http\Requests\DeleteAddressRequest;
use App\Http\Requests\GetAddressesRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Repositories\AddressRepository;

class AddressController extends ApiController
{
    use HasCrud;

    public function index(GetAddressesRequest $request, AddressRepository $repository)
    {
        $items = $repository->index($request);

        return $this->_respondIndex(
            $request,
            $items,
            AddressResource::collection($items)
        );
    }

    public function create(CreateAddressRequest $request, AddressRepository $repository)
    {
        return $this->_create($repository->create($request->toArray()));
    }

    public function update(AddressRepository $repository, Address $address, UpdateAddressRequest $request)
    {
        $repository->setModel($address)->update($request->toArray());

        return $this->respondOk();
    }

    public function delete(DeleteAddressRequest $request, Address $address, AddressRepository $repository)
    {
        $repository->setModel($address)->delete();
    }
}
