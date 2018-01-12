<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $company = new Company();
         //Кол-во компаний
         //Пять последних
         $data = [
             'count'     => $company->count(),
             'latest'    => $company->latest()->take(5)->get(),
         ];

         return view('index', $data);
     }
}
