<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {

        $departments = Department::query()
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('department.index', ['departments' => $departments]);
    }

    public function store(DepartmentRequest $request)
    {

        Department::query()
            ->create([
                    'name' => $request->name,
                    'user_id' => Auth::user()->id,
                ]
            );
        return redirect()->route('clients.load');
    }
}
