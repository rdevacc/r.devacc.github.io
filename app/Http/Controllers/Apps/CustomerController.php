<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Customers
        $costumers = Customer::when(request()->q, function ($costumers) {
            $costumers = $costumers->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(10);

        // Return inertia
        return Inertia::render('Apps/Customers/Index', [
            'customers' => $costumers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // Return Inertia
        return Inertia::render('Apps/Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:customers',
            'division' => 'required',
            'address' => 'required',
        ]);

        // Create Customer
        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'division' => $request->division,
            'address' => $request->address,
        ]);

        // Redirect
        return redirect()->route('apps.customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return Inertia::render('Apps/Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {

        // Validate Request
        $this->validate($request, [
            'name'      => 'required',
            'phone'   => 'required|unique:customers,phone,' . $customer->id,
            'division'   => 'required',
            'address'   => 'required',
        ]);

        // Update Customers
        $customer->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'division' => $request->division,
            'address' => $request->address,
        ]);

        // Redirect
        return redirect()->route('apps.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Find Customer by ID
        $customer = Customer::findOrFail($id);

        // Delete Customer
        $customer->delete();

        // Redirect
        return redirect()->route('apps.customers.index');
    }
}
