<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the employee.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editableEmployee = null;
        $companyList = Company::pluck('name', 'id');

        $employeeQuery = Employee::where(function ($query) {
            $searchQuery = request('q');
            $query->where('first_name', 'like', '%'.$searchQuery.'%');
            $query->orWhere('last_name', 'like', '%'.$searchQuery.'%');
        });

        if ($companyId = request('company_id')) {
            $employeeQuery->where('company_id', $companyId);
        }

        $employees = $employeeQuery->with('company')->paginate();

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableEmployee = Employee::find(request('id'));
        }

        return view('employees.index', compact('employees', 'editableEmployee', 'companyList'));
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', new Employee);

        $newEmployee = $this->validate($request, [
            'first_name' => 'required|max:60',
            'last_name'  => 'required|max:60',
            'company_id' => 'required|numeric|exists:companies,id',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|max:255',
        ]);

        $newEmployee['creator_id'] = auth()->id();

        Employee::create($newEmployee);

        return redirect()->route('employees.index');
    }

    /**
     * Update the specified employee in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        $employeeData = $this->validate($request, [
            'first_name' => 'required|max:60',
            'last_name'  => 'required|max:60',
            'company_id' => 'required|numeric|exists:companies,id',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|max:255',
        ]);

        $routeParam = request()->only('page', 'q');

        $employee->update($employeeData);

        return redirect()->route('employees.index', $routeParam);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        $this->validate(request(), [
            'employee_id' => 'required',
        ]);

        $routeParam = request()->only('page', 'q');

        if (request('employee_id') == $employee->id && $employee->delete()) {
            return redirect()->route('employees.index', $routeParam);
        }

        return back();
    }
}
