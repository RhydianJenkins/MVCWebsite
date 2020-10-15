<?php
namespace Application\Form;

use Laminas\Form\Form;

class ResetForm extends Form {
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

        // submit button
        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Reset Password',
                'class' => 'btn btn-primary',
            ],
        ]);
    }
}