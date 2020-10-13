<?php
namespace Application\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilter\Input;
use Laminas\Validator;

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

        // ID
        // $inputFilter->add([
        //     'name' => 'id',
        //     'required' => true,
        //     'filters' => [
        //         ['name' => Validator\Digits::class],
        //     ],
        // ]);

        // username
        // $inputFilter->add([
        //     'name' => 'username',
        //     'required' => true,
        //     // 'filters' => [
        //     //     ['name' => Validator\NotEmpty::class],
        //     // ],
        // ]);

        // // name
        // $inputFilter->add([
        //     'name' => 'name',
        //     'required' => true,
        //     // 'filters' => [
        //     //     ['name' => Validator\NotEmpty::class],
        //     // ],
        // ]);

        // // email
        // $inputFilter->add([
        //     'name' => 'email',
        //     'required' => true,
        //     // 'filters' => [
        //     //     ['name' => Validator\EmailAddress::class],
        //     // ],
        // ]);

        // // password
        // $inputFilter->add([
        //     'name' => 'password',
        //     'required' => true,
        //     // 'filters' => [
        //     //     ['name' => Validator\NotEmpty::class],
        //     // ],
        // ]);

        // // password-confirm
        // $inputFilter->add([
        //     'name' => 'password-confirm',
        //     'required' => true,
        //     // 'validators' => [
        //     //     [
        //     //         'name'    => Validator\Identical::class,
        //     //         'options' => [
        //     //             'token' => 'password',
        //     //         ],
        //     //     ],
        //     // ],

        //     // 'filters' => [
        //     //     ['name' => Validator\NotEmpty::class],
        //     // ],
        // ]);

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