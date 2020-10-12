<?php
namespace Application\Form;

use Laminas\Form\Fieldset;

class LoginFormFieldset extends Fieldset {
    public function init() {
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

        // password
        $this->add([
            'type' => 'text',
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
