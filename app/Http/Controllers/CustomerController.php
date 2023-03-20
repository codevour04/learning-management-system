<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        Customer::create([
            "first_name" => $request->firstName,
            "middle_name" => $request->middleName,
            "last_name" => $request->lastName,
            "address" => $request->address,
            "city" => $request->city
        ]);
    }

    public function show(Customer $customer)
    {
    }

    public function edit(Customer $customer)
    {
    }


    public function update(Request $request, Customer $customer)
    {
    }

    public function destroy(Customer $customer)
    {
    }
}
