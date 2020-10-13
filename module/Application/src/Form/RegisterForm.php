<?php
namespace Application\Form;

use Laminas\Form\Form;

class RegisterForm extends Form {
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
                'class' => 'form-control',
            ],
        ]);

        // name
        $this->add([
            'type' => 'text',
            'name' => 'name',
            'options' => [
                'label' => 'Name',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Name',
                'class' => 'form-control',
            ],
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
                'class' => 'form-control',
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
                'class' => 'form-control',
            ],
        ]);

        // password confirm
        $this->add([
            'type' => 'password',
            'name' => 'password-confirm',
            'options' => [
                'label' => 'Password (again)',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Password',
                'class' => 'form-control',
            ],
        ]);

        // submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Register',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}