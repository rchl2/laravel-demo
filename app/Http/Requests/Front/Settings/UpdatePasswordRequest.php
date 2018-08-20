<?php

namespace App\Http\Requests\Front\Settings;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|min:5|confirmed',
        ];
    }

    public function old_password(): string
    {
        return (string) $this->get('old_password');
    }

    public function new_password(): string
    {
        return (string) $this->get('new_password');
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'old_password.required'  => trans('pages/account.change_password.validation.old_password_is_required'),
            'new_password.required'  => trans('pages/account.change_password.validation.new_password_required'),
            'new_password.min'       => trans('pages/account.change_password.validation.new_password_min_incorrect'),
            'new_password.confirmed' => trans('pages/account.change_password.validation.new_password_confirmed_incorrect'),
        ];
    }

    /**
     * Return response with array of $errors.
     */
    public function response(array $errors)
    {
        return \Redirect::back()->withErrors($errors)->withInput();
    }
}
