<?php
namespace App\Traits;
use Illuminate\Http\Request;

use Validator;

trait ResponseTrait
{
    function setBoolian($val)
    {
        if ($val == 'true')
            return true;
        return false;
    }
    function isCorrectCompany($modelClass, $receivedPks)
    {
        if (isset(auth()->user()->fk_company)) {
            $model = new $modelClass;

            $primaryKey = $model->getKeyName();

            $counter = $modelClass::whereIn($primaryKey, $receivedPks)
                ->join('users as registrar', $model->getTable() . '.fk_registrar', '=', 'registrar.id')
                ->where('registrar.fk_company', auth()->user()->fk_company)
                ->count();

            if ($counter == 0)
                throw new \Exception(__('messages.error.invalid_company'));
            return true;
        }
    }
    function successDelete()
    {
        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'code' => 201,
        ], 201);
    }
    protected function checkDuplicateAttributes($checkExist, $reqParamArray)
    {
        $fieldErrorMessages = [];
        foreach ($reqParamArray as $param) {
            $fieldErrorMessages[$param] = __('validation.attributes.' . $param);
        }
        foreach ($reqParamArray as $param) {
            if (isset($fieldErrorMessages[$param]) && $checkExist->$param == request($param)) {
                return $fieldErrorMessages[$param];
            }
        }
        return null;
    }
    function checkLocalization()
    {
        $request = new Request();

        $locale = $request->header('Accept-Language', 'en');

        if (!in_array($locale, ['en', 'fa'])) {
            $locale = 'fa';
        }

        return $locale;
    }
    public function serverErrorResponse($message = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message ?: __('messages.error.server_error'),
            'code' => 500,
        ], 500);
    }
    public function clientErrorResponse($message = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message ?: __('messages.error.server_error'),
            'code' => 400,
        ], 400);
    }
    public function successMessage($data = null)
    {
        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'code' => 201,
        ], 201);
    }
    public function ownDataCheckError($error)
    {
        $customErrors = Validator::make([], []);
        $customErrors->errors()->add('owndata', $error);

        return response()->json([
            'status' => 'error',
            'message' => __('messages.error.validation'),
            'code' => 400,
            'issues' => $customErrors->errors(),
        ], 400);
    }
    public function dataErrorResponse($data)
    {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.error.validation'),
            'code' => 400,
            'issues' => $data->errors(),
        ], 400);
    }
    public function incurrectInput()
    {
        return response()->json([
            'status' => 'error',
            'message' => __('messages.error.incurrect_input'),
            'code' => 400,
        ], 400);
    }

    function addRegistrar($array)
    {
        if (isset(auth()->user()->id)) {
            $array['fk_registrar'] = auth()->user()->id;
            return $array;
        }
    }

    public function checkOwner($fk_registrar, $user_id)
    {
        return $fk_registrar === $user_id;
    }
}