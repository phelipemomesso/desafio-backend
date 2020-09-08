<?php

namespace Modules\Transaction\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ExportRequest extends FormRequest
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
                    'user_id' => [
                        'required', 'numeric',
                    ],
                    'filter_type' => [
                        'required', 'in:all,monthYear,last30days',
                    ],
                    'date_filter' => [
                        'required_if:filter_type,monthYear', 'date_format:m/Y'
                    ],
                ];
            case Request::METHOD_PUT:
                return [];
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
