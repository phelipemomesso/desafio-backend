<?php

namespace Modules\User\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
                    'name' => [
                        'required', 'max:100',
                    ],
                    'birthdate' => [
                        'required', 'date', 'before:'. Carbon::now()->subYears(18)->format('Y-m-d')
                    ],
                    'email' => [
                        'required', 'email', 'max:255', 'unique:user_users,email',
                    ],
                    'password' => [
                        'required'
                    ],
                ];
            case Request::METHOD_PUT:
                return [
                    'name' => [
                        'required', 'max:100',
                    ],
                    'birthdate' => [
                        'required', 'date', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')
                    ],
                    'email' => [
                        'required', 'email', 'max:255', Rule::unique('user_users')->ignore($this->route('user'), 'id'),
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
