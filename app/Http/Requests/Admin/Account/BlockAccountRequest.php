<?php

namespace App\Http\Requests\Admin\Account;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class BlockAccountRequest extends FormRequest
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
            'duration'  => 'required|numeric|between:1,365',
            'duration_type' => 'required|integer|between:1,2',
            'reason' => 'required|string|max:191|min:3',
            'ip_ban' => 'nullable',
        ];
    }

    public function duration(): int
    {
        return (int) $this->get('duration');
    }

    public function duration_type(): int
    {
        return (int) $this->get('duration_type');
    }

    public function reason(): string
    {
        return (string) $this->get('reason');
    }

    public function ip_ban(): int
    {
        return (int) $this->get('ip_ban');
    }

    public function admin(): string
    {
        return (string) $this->admin['login'];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'duration.required' => trans('admin/pages/account.block.validation.duration_is_required'),
            'duration.numeric' => trans('admin/pages/account.block.validation.duration_numeric_incorrect'),
            'duration.between' => trans('admin/pages/account.block.validation.duration_between_incorrect'),

            'duration_type.required' => trans('admin/pages/account.block.validation.duration_type_is_required'),
            'duration_type.integer' => trans('admin/pages/account.block.validation.duration_type_integer_incorrect'),
            'duration_type.between' => trans('admin/pages/account.block.validation.duration_type_between_incorrect'),

            'reason.required' => trans('admin/pages/account.block.validation.reason_is_required'),
            'reason.string' => trans('admin/pages/account.block.validation.reason_is_incorrect'),
            'reason.max' => trans('admin/pages/account.block.validation.reason_max_incorrect'),
            'reason.min' => trans('admin/pages/account.block.validation.reason_min_incorrect'),
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
