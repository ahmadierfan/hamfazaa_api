<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\m_company;

use App\Traits\ResponseTrait;

class MCompanyController extends Controller
{
    use ResponseTrait;
    function companyCreator()
    {
        $company = $this->justCreate();

        return $company->pk_company;
    }
    function justCreate()
    {

        $data = m_company::create(
            [
                "company" => "-"
            ]
        );
        return $data;
    }
}
