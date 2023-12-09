<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    public function created(Customer $customer)
    {
        // Handle the created event
    }

    public function updated(Customer $customer)
    {
        // Handle the updated event
    }

    public function deleted(Customer $customer)
    {
        // Handle the deleted event
    }

    public function creating(Customer $customer)
    {
        $customer->name = $customer->firstName ." ". $customer->lastName;
    }
}
