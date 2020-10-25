<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\Captcha;
use Laminas\Captcha\ReCaptcha as ReCaptcha;

class RegisterForm extends Form {
    public function __construct($name = null, $recaptchaOptions) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'id',
        ]);

        // firstname
        $this->add([
            'type' => Element\Text::class,
            'name' => 'firstname',
            'options' => [
                'label' => 'First name',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'First name',
                'class' => 'form-control input-group',
            ],
        ]);

        // surname
        $this->add([
            'type' => Element\Text::class,
            'name' => 'surname',
            'options' => [
                'label' => 'Surname',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Surname',
                'class' => 'form-control input-group',
            ],
        ]);
        
        // email
        $this->add([
            'type' => Element\Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'you@email.com',
                'class' => 'form-control input-group',
            ],
        ]);

        // password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Password',
                'class' => 'form-control input-group',
            ],
        ]);

        // password confirm
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password-confirm',
            'options' => [
                'label' => 'Password (again)',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Confirm Password',
                'class' => 'form-control input-group',
            ],
            'validators' => [
                [
                    'name'    => Validator\Identical::class,
                    'options' => [
                        'token' => 'password',
                        'message' => 'Passwords did not match.'
                    ],
                ],
            ],
        ]);

        // captcha
        $this->add([
            'type' => Element\Captcha::class,
            'name' => 'captcha',
            'options' => [
                'label' => 'Please verify you are human',
                'captcha' => new ReCaptcha($recaptchaOptions),
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        // submit button
        $this->add([
            'type' => Element\Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Register',
                'class' => 'btn btn-primary d-flex mx-auto',
            ],
        ]);
    }
}