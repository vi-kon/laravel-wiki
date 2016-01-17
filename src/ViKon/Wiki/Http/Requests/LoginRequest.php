<?php namespace ViKon\Wiki\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;
use ViKon\Auth\Guard;

/**
 * Class LoginRequest
 *
 * @package ViKon\Wiki\Http\Requests
 *
 * @author  Kovács Vince<vincekovacs@hotmail.com>
 */
class LoginRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !app('auth')->check();
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

        if (!app('auth')->validate($this->only('username', 'password'))) {
            $validator->messages()->add('form', trans('wiki::auth.modal.login.form.alert.not-match.content'));
        } elseif (app('auth')->getLastAttempted()->blocked) {
            $validator->messages()->add('form', trans('wiki::auth.modal.login.form.alert.blocked.content'));
        }

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
