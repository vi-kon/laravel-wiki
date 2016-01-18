<?php namespace ViKon\Wiki\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\Validator;
use ViKon\Auth\Guard;

/**
 * Class LoginRequest
 *
 * @package ViKon\Wiki\Http\Requests
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !app(Guard::class)->check();
    }

    /**
     * @param \Illuminate\Validation\Factory $factory
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator(ValidationFactory $factory)
    {
        $validator = $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages()
        );

        $validator->after(function (Validator $validator) {
            // Run advanced validation only if simple validation passes
            if (count($validator->messages()->all()) !== 0) {
                return;
            }

            $guard = $this->container->make(Guard::class);

            if (!$guard->validate($this->only('username', 'password'))) {
                $validator->messages()->add('form', trans('wiki::auth/login.modal.login.form.alert.not-match.content'));
            } elseif ($guard->getLastAttempted()->blocked) {
                $validator->messages()->add('form', trans('wiki::auth/login.modal.login.form.alert.blocked.content'));
            }
        });

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
            'username' => 'required',
            'password' => 'required',
            'remember' => '',
        ];
    }

}
