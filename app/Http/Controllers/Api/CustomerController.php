<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function index() {
        $customers = Customer::orderBy('name')->paginate(10);
        return CustomerResource::collection($customers);
    }

    public function store(CustomerStoreRequest $request): JsonResponse{
        $customer = Customer::create($request->validated());
        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Customer $customer): CustomerResource {
        return new CustomerResource($customer);
    }
}
