<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\Captcha;
use Laminas\Captcha\ReCaptcha as ReCaptcha;

class ResetForm extends Form {
    public function __construct($name = null, $recaptchaOptions) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'id',
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
                'value' => 'Reset Password',
                'class' => 'btn btn-primary d-flex mx-auto',
            ],
        ]);
    }
}