<?php
namespace Application\Form;

use Laminas\Form\Form;

class LoginForm extends Form {
    public function __construct($name = null) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => 'hidden',
            'name' => 'id',
        ]);

        // email
        $this->add([
            'type' => 'Email',
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
            'type' => 'password',
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

        // submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Log in',
                'class' => 'btn btn-primary d-flex mx-auto',
            ],
        ]);
    }
}