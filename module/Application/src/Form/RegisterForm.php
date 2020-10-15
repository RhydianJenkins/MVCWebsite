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

        // firstname
        $this->add([
            'type' => 'text',
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
            'type' => 'text',
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
                'class' => 'form-control input-group',
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