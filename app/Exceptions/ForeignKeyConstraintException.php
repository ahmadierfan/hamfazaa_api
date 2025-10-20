<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\DB;

class ForeignKeyConstraintException extends Exception
{
    public function render($request)
    {
        $relationTable = $this->getRelationTableFromError($this->getMessage());
        $relationName = __('validation.attributes.' . $relationTable) ?? $relationTable;

        return $this->clientErrorResponse(
            __('messages.error.has_relation_to') . ' ' . $relationName
        );
    }

    protected function clientErrorResponse($message, $code = 422)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'message' => $message,
                'errors' => ['constraint' => [$message]]
            ], $code);
        }

        return back()->withErrors(['constraint' => $message]);
    }

    protected function getRelationTableFromError($errorMessage)
    {
        if (preg_match('/REFERENCES `(.+?)`/', $errorMessage, $matches)) {
            return $matches[1];
        }

        if (preg_match('/CONSTRAINT `(.+?)` FOREIGN KEY/', $errorMessage, $matches)) {
            $constraint = $matches[1];
            if (preg_match('/^(.+?)_fk_/', $constraint, $parts)) {
                return $parts[1];
            }
            return $constraint;
        }

        // اگر هیچکدام کار نکرد، از کل پیام استخراج کنیم
        if (preg_match('/`(.+?)`/', $errorMessage, $matches)) {
            return $matches[1];
        }

        return 'related_data';
    }
}