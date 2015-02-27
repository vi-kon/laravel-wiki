<?php namespace ViKon\Wiki\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;

class LoginRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return !\Auth::check();
    }

    /**
     * @param \Illuminate\Validation\Factory $factory
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator(ValidationFactory $factory) {
        $validator = $factory->make(
            $this->all(), $this->container->call([$this, 'rules']), $this->messages()
        );

        if (!\Auth::attempt($this->only('username', 'password'), $this->get('remember', false), false)) {
            $validator->messages()->add('form', trans('wiki::auth.modal.login.form.alert.not-match.content'));
        } elseif (\Auth::getLastAttempted()->blocked) {
            $validator->messages()->add('form', trans('wiki::auth.modal.login.form.alert.blocked.content'));
        }

        return $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'username' => 'required',
            'password' => 'required',
            'remember' => '',
        ];
    }

}
