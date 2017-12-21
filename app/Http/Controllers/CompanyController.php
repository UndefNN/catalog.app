<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Opf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    public function viewCompany( $id ) {
        $company = Company::whereId($id)->get()->first();
        return view('page.company', ['company' => $company]);
    }

    public function create() {
        $opf = Opf::all('full');
        return view('page.form.company-add', ['opf' => $opf]);
    }

    public function viewAll() {
        $companies = Company::all();
        return view('page.company-table', ['companies' => $companies]);
    }

    public function store(Request $request) {
        $this->validate( $request, [
            'short_name'    => 'required|string',
            'full_name'     => 'nullable|string',
            'opf_id'        => 'nullable|integer|exists:opf,id',
            'inn'           => 'nullable|integer',
            'address'       => 'nullable|string',
            'web'           => 'nullable|string',
            'email'         => 'required|regex:/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/',
            'description'   => 'string'
        ]);

        $company = new Company();

        $company->short_name  = $request->input('short_name');
        $company->full_name   = $request->input('full_name');
        $company->address     = $request->input('address');
        $company->inn         = $request->input('inn');
        $company->web         = $request->input('web');
        $company->email       = $request->input('email');
        $company->description = $request->input('description');
        $company->opf_id      = $request->input('opf_id');

        $company->save();

        return Redirect::route('company.view', $company)->with(['message' => 'Компания успешно добавлена']);

    }
}