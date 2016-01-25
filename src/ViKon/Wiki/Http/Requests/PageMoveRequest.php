<?php

namespace ViKon\Wiki\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;
use ViKon\Auth\Helper\FormRequestRouteAuthorizer;

/**
 * Class PageMoveRequest
 *
 * @package ViKon\Wiki\Http\Requests
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class PageMoveRequest extends FormRequest
{
    use FormRequestRouteAuthorizer;

    /**
     * @param \Illuminate\Validation\Factory $factory
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator(ValidationFactory $factory)
    {
        $input = $this->all();

        if (array_key_exists('destination', $input)) {
            $input['destination'] = trim($input['destination'], " /\t\n\r\0\x0B");
            $this->getInputSource()->set('destination', $input['destination']);
        }

        $validator = $factory->make(
            $input, $this->container->call([$this, 'rules']), $this->messages()
        );

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source'      => '', // disabled field
            'destination' => 'unique:wiki_pages,url',
        ];
    }
}