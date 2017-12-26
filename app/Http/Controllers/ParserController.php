<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Parser;

class ParserController extends Controller
{
    public function getList ( $string = '') {
        $parser = new Parser();
        return $parser->getListCompanies($string);
    }

    public function getCompany ( $id = null ) {
        $parser = new Parser();
        return $parser->getCompany( '/id/'.$id);
    }

    public function regexGetCompany ( $id = null) {
        $parser = new Parser();
        return  $parser->regexGetCompany('/id/'.$id);
    }
}
