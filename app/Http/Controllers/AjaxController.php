<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Opf;
use Fomvasss\Dadata\Facades\DadataSuggest;
use App\Classes\Parser;

class AjaxController extends Controller
{
    /**
     * Поиск адресса по строке
     *
     * @return array
     */
    public function searchAddress()
    {
        $string = \Request::get('q', '');
        $limit = \Request::get('limit', 10);

        $addresses = DadataSuggest::suggest("address", ["query"=>$string, "count"=>$limit]);

        $data = array();

        preg_match_all('/(\w{3,})/u', $string, $words);

        foreach ($addresses['suggestions'] as $address) {

/*            foreach ($words[1] as $word) {
                $address['value'] = preg_replace( '/('.$word.')/ui', '<b>$1</b>', $address['value']);
            }*/

            $data[] = array(
                'name' => $address['value'],
                'unrestricted'  => $address['unrestricted_value'],
                'postal_code'   => $address['data']['postal_code'],
                'query'         => $string
            );
        }

        return $data;

    }

    /**
     * Поиск компании по названию
     *
     * @return array
     * */

    public function searchCompany() {

        $string = \Request::get('q', '');
        $limit = \Request::get('limit', 10);

        $company = new Company();

        $result = $company
            ->where('full_name', 'like', "%$string%")
            ->limit($limit)
            ->get();

        $data = array();

        foreach ( $result as $key => $item ) {
            $data[] = array (
                'name' => $item->short_name,
                'description' => $item->address,
                'link' => \URL::route('company.view', $item['id']),
            );
        }

        return $data;
    }

    public function searchOpf () {
        $string = \Request::get('q', '');
        $limit = \Request::get('limit', 10);

        $opf = new Opf();

        $result = $opf
            ->where('full', 'like', "%$string%")
            ->limit($limit)
            ->get();

        $data = array();

        foreach ( $result as $key => $item ) {
            $data[] = array (
                'id'            => $item->id,
                'name'          => $item->full,
//                'description'   => $item->full,
            );
        }

        return $data;
    }

    public function searchCompanyProfile() {
        $string = \Request::get('q', '');
        $limit = \Request::get('limit', 10);

        $parser = new Parser();

        $companies =  $parser->getListCompanies($string);
        $data = array();

        foreach ($companies as $company) {
            $data[] = array(
                'name'        => $company['name'],
                'description' => $company['address'],
                'id'          => $company['link']
            );
        }

        return $data;
    }

    public function getCompany (\Request $request) {

        $id = $request::get('id');
        $parser = new Parser();

        return $parser->getCompany($id);
    }
}
