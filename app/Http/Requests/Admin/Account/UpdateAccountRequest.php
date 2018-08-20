<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
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
            'login'                     => 'required|string|min:3|max:16|'.Rule::unique('account.account', 'login')->ignore($this->user['id']).'',
            'email'                     => 'required|string|email|max:64|'.Rule::unique('account.account', 'email')->ignore($this->user['id']).'',
            'pin'                       => 'required|numeric|digits_between:5,5',
            'social_id'                 => 'required|numeric|digits_between:7,7',
        ];
    }

    public function login(): string
    {
        return (string) $this->get('login');
    }

    public function email(): string
    {
        return (string) $this->get('email');
    }

    public function pin(): string
    {
        return (string) $this->get('pin');
    }

    public function social_id(): string
    {
        return (string) $this->get('social_id');
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'login.required'  => trans('admin/pages/account.update.validation.login_is_required'),
            'login.string'    => trans('admin/pages/account.update.validation.login_is_incorrect'),
            'login.min'       => trans('admin/pages/account.update.validation.login_min_incorrect'),
            'login.max'       => trans('admin/pages/account.update.validation.login_max_incorrect'),
            'login.unique'    => trans('admin/pages/account.update.validation.login_unique_incorrect'),

            'email.required' => trans('admin/pages/account.update.validation.email_required'),
            'email.string'   => trans('admin/pages/account.update.validation.email_is_incorrect'),
            'email.email'    => trans('admin/pages/account.update.validation.email_format_is_incorrect'),
            'email.max'      => trans('admin/pages/account.update.validation.email_max_incorrect'),
            'email.unique'   => trans('admin/pages/account.update.validation.email_unique_incorrect'),

            'pin.required'       => trans('admin/pages/account.update.validation.pin_is_required'),
            'pin.numeric'        => trans('admin/pages/account.update.validation.pin_numeric_incorrect'),
            'pin.digits_between' => trans('admin/pages/account.update.validation.pin_digits_between_incorrect'),

            'social_id.required'       => trans('admin/pages/account.update.validation.social_id_is_required'),
            'social_id.numeric'        => trans('admin/pages/account.update.validation.social_id_numeric_incorrect'),
            'social_id.digits_between' => trans('admin/pages/account.update.validation.social_id_digits_between_incorrect'),
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
