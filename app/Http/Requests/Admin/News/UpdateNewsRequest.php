<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
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
            'title'    => 'required|string|min:3|max:190',
            'body'     => 'required|string',
        ];
    }

    public function title(): string
    {
        return (string) $this->get('title');
    }

    public function body(): string
    {
        return (string) $this->get('body');
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'title.required' => trans('admin/pages/news.update.validation.title_is_required'),
            'title.string' => trans('admin/pages/news.update.validation.title_string_incorrect'),
            'title.min' => trans('admin/pages/news.update.validation.title_min_incorrect'),
            'title.max' => trans('admin/pages/news.update.validation.title_max_incorrect'),

            'body.required' => trans('admin/pages/news.update.validation.body_is_required'),
            'body.string' => trans('admin/pages/news.update.validation.body_string_incorrect'),
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
