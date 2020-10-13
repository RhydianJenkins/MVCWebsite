<?php
namespace Application\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilter\Input;
use Laminas\Validator;
use Laminas\I18n\Validator\Alpha;

class User implements InputFilterAwareInterface {
    private $id;
    private $username;
    private $password;
    private $email;
    private $name;

    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->username = !empty($data['username']) ? $data['username'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
    }
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter() {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        // username
        $inputFilter->add([
            'name' => 'username',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 3,
                        'max' => 20,
                    ]
                ],
            ],
        ]);

        // name
        $inputFilter->add([
            'name' => 'name',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 2,
                        'max' => 50,
                    ]
                ],
                [
                    'name' => Alpha::class,
                    'options' => [
                        'allowWhiteSpace' => true,
                    ],
                ],
            ],
        ]);

        // email
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                ['name' => Validator\EmailAddress::class],
            ],
        ]);

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
    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getName() {
        return $this->name;
    }
}