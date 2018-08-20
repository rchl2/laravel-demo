<?php

namespace App\Http\Requests\Front\Settings;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
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
            'password'  => 'required',
            'new_email' => 'required|email|confirmed|unique:account.account,email',
        ];
    }

    public function password(): string
    {
        return (string) $this->get('password');
    }

    public function new_email(): string
    {
        return (string) $this->get('new_email');
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'password.required'   => trans('pages/account.change_email.validation.password_is_required'),
            'new_email.required'  => trans('pages/account.change_email.validation.new_email_required_incorrect'),
            'new_email.email'     => trans('pages/account.change_email.validation.new_email_email_incorrect'),
            'new_email.confirmed' => trans('pages/account.change_email.validation.new_email_confirmed_incorrect'),
            'new_email.unique'    => trans('pages/account.change_email.validation.new_email_unique_incorrect'),
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
