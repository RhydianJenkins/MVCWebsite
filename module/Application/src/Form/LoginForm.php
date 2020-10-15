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

        // username
        $this->add([
            'type' => 'text',
            'name' => 'username',
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Username',
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
                'value' => 'Login',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}