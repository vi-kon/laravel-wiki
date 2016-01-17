<?php

namespace ViKon\Wiki\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PageRequest
 *
 * @package ViKon\Wiki\Http\Requests
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class PageRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => 'required',
            'content' => 'required',
        ];
    }
}