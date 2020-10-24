<?php
namespace Application\Form;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\Form\Element;
use Laminas\Form\Form;
use Laminas\Validator;

class ResetPasswordForm extends Form implements InputFilterAwareInterface {
    public function __construct($name = null) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => Element\Hidden::class,
            'name' => 'id',
        ]);

        // password
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'New Password',
                'class' => 'form-control input-group',
            ],
        ]);
        
        // password confirm
        $this->add([
            'type' => Element\Password::class,
            'name' => 'password-confirm',
            'options' => [
                'label' => 'Password (again)',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Confirm Password',
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

    public function getInputFilter() {
        if (property_exists($this, 'inputFilter')) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        // password
        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 6,
                        'max' => 50,
                    ]
                ],
            ],
        ]);

        // password-confirm
        $inputFilter->add([
            'name' => 'password-confirm',
            'required' => true,
            'validators' => [
                [
                    'name'    => Validator\Identical::class,
                    'options' => [
                        'token' => 'password',
                        'message' => 'Passwords did not match.'
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
}