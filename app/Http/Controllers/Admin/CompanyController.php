<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $user;
    private $company;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Company $company, User $user)
    {
        $this->middleware(['auth', 'adminAuthorization']);
        $this->authorizeResource(Company::class, 'company');
        $this->company = $company;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('user')->orderBy('name', 'asc')->paginate(15);

        return view('admin.company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = $this->user->getCompanyUsers()->pluck('email', 'id');
        
        return view('admin.company.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        try{       
            $this->company->createModel($request->validated());
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!')->withInput();
        }

        return redirect()->route('admin.company.index')->with('success', 'Company created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $users = $this->user->getCompanyUsers()->pluck('email', 'id');

        return view('admin.company.edit', compact('company', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company)
    {
        try{
            $company->updateModel($request->validated());
        }
        catch (Exception $e) {
            logger($e);
            return back()->with('error', 'Oops something went wrong!');
        }

        return redirect()->route('admin.company.index')->with('success', 'Company updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.company.index')->with('success', 'Company deleted successfully!');
    }
}
