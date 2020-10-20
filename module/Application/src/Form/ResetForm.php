<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class ResetForm extends Form {
    public function __construct($name = null) {
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