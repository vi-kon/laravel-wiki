<?php

namespace ViKon\Wiki\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use ViKon\Auth\Helper\FormRequestRouteAuthorizer;

/**
 * Class PageRequest
 *
 * @package ViKon\Wiki\Http\Requests
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class PageRequest extends FormRequest
{
    use FormRequestRouteAuthorizer;

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