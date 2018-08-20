<?php

namespace App\Http\Requests\Admin\News;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewsRequest extends FormRequest
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
            'title'    => 'required|min:3|max:190',
            'body'     => 'required',
            'image'    => 'image|mimes:jpeg,bmp,png',
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

    public function image()
    {
        return $this->get('image');
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages()
    {
        return [
            'title.required' => trans('admin/pages/news.create.validation.title_is_required'),
            'title.min'      => trans('admin/pages/news.create.validation.title_min_incorrect'),
            'title.max'      => trans('admin/pages/news.create.validation.title_max_incorrect'),

            'body.required' => trans('admin/pages/news.create.validation.body_is_required'),

            'image.image' => trans('admin/pages/news.create.validation.image_image_incorrect'),
            'image.mimes' => trans('admin/pages/news.create.validation.image_mimes_incorrect'),
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
