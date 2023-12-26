<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    private $countries;

    public function index()
    {
        $this->countries = collect(config('countries'));

        $customers = Customer::filterByCountry(request()->country)->paginate();
        $customersCollection = $customers->transform(fn ($customer) => $this->formatCustomer($customer))
            ->when(request()->valid, fn ($collection) => $collection->filter(fn ($customer) => $customer->state === (request()->valid === 'true' ? 'OK' : 'NOK')));

        $customers->setCollection($customersCollection);

        return view('welcome', [
            'countries' => $this->countries,
            'customers' => $customers
        ]);
    }

    private function formatCustomer($customer)
    {
        if (!preg_match('/\((\d+)\)/', $customer->phone, $country_code)) {
            throw new Exception("Phone is not formatted: " . $customer->phone);
        }

        $searchCountry = $this->countries->firstWhere('code', '+' . ($country_code[1] ?? null));
        $customer->country = (object) $searchCountry;
        $customer->state = preg_match('/' . $searchCountry['regex'] . '/', $customer->phone) ? 'OK' : 'NOK';

        return $customer;
    }
}
