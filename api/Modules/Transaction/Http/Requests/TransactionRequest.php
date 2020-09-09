<?php

namespace Modules\Transaction\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case Request::METHOD_POST:
                return [
                    'value' => [
                        'required', 'numeric',
                    ],
                    'user_id' => [
                        'required', Rule::exists('user_users', 'id'),
                    ],
                    'type_id' => [
                        'required', Rule::exists('transaction_types', 'id'),
                    ],
                ];
            case Request::METHOD_PUT:
                return [
                    'value' => [
                        'required', 'numeric',
                    ],
                    'user_id' => [
                        'required', Rule::exists('user_users', 'id'),
                    ],
                    'type_id' => [
                        'required', Rule::exists('transaction_types', 'id'),
                    ],
                ];
            default:
                return [];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
