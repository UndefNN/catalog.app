<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Opf;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    public function viewCompany( $id ) {
        $company = Company::whereId($id)->get()->first();
        return view('page.company', ['company' => $company]);
    }

    public function create() {
        return view('page.form.company-add');
    }

    public function viewAll() {
        $companies = Company::all();

        return view('page.company-table', ['companies' => $companies]);
    }

    public function store(Request $request) {


        $this->validate( $request, [
            'short_name'     => 'required|string',
            'full_name'      => 'nullable|string',
            'opf_id'         => 'nullable|integer|exists:opf,id',
            'inn'            =>  array('nullable', 'regex:/(^\d{10}\b)|(^\d{12}$)/', 'integer', 'unique:companies,inn'),
            'address'        => 'nullable|string',
            'web'            => 'nullable|string',
            'email'          => 'required|regex:/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/',
            'description'    => 'nullable|string',
            'phone.*.number' => 'nullable|integer',
        ], [
            'short_name.required' => 'Заполните название компании',
            'short_name.string'   => 'Название компании должно быть строкой',
            'inn.unique'          => 'Организация с таким ИНН уже существует',
            'inn.*'               => 'Поле ИНН должно содержать 10 или 12 цифр',
            'email.*'             => 'Обязательно укажите валидный Email',
            'description.*'       => 'Заполните описание компании',
        ]);


        $company = new Company();

        $company->short_name  = $request->input('short_name');
        $company->full_name   = $request->has('full_name') ? $request->input('full_name') : $request->input('short_name');
        $company->address     = $request->input('address');

        if ($request->has('inn')) {
            $company->inn     = $request->input('inn');
        }

        $company->web         = $request->input('web');
        $company->email       = $request->input('email');
        $company->description = $request->input('description');
        $company->opf_id      = $request->input('opf_id');

        $company->save();

        if ($request->has('phone')) {
            $phones = $request->input('phone');

            foreach ($phones as $phone) {
                $company->phones()->save( new Phone($phone));
            }
        }

        return Redirect::route('company.view', $company)->with(['message' => 'Компания успешно добавлена']);

    }
    public function test_add(){
        // var_dump($request->all());die;

    }
}