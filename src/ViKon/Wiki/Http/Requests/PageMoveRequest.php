<?php

namespace ViKon\Wiki\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

/**
 * Class PageMoveRequest
 *
 * @author  Kovács Vince <vincekovacs@hotmail.com>
 *
 * @package ViKon\Wiki\Http\Requests
 */
class PageMoveRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return \Auth::check();
    }

    /**
     * @param \Illuminate\Validation\Factory $factory
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator(ValidationFactory $factory) {
        $input = $this->all();

        if (isset($input['destination'])) {
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
    public function rules() {
        return [
            'source'      => '', // disabled field
            'destination' => 'unique:wiki_pages,url',
        ];
    }
}