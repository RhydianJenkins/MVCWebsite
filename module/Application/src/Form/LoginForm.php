<?php
namespace Application\Form;

use Laminas\Form\Form;

class LoginForm extends Form {
    public function init() {
        $this->add([
            'name' => 'post',
            'type' => LoginFormFieldset::class,
        ]);
    }
}