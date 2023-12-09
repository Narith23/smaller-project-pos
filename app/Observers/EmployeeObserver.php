<?php

namespace App\Observers;

use App\Models\Employee;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        // Handle the created event
    }

    public function updated(Employee $employee)
    {
        // Handle the updated event
    }

    public function deleted(Employee $employee)
    {
        // Handle the deleted event
    }

    public function creating(Employee $employee)
    {
        $employee->name = $employee->firstName ." ". $employee->lastName;
    }
}
