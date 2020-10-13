<?php
namespace Application\Form;

use Laminas\Form\Form;

class RegisterForm extends Form {
    public function init() {
        $this->add([
            'name' => 'post',
            'type' => RegisterFormFieldset::class,
        ]);
    }
}