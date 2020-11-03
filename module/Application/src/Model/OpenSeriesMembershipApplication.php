<?php
namespace Application\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilter\Input;
use Laminas\Validator;

class OpenSeriesMembershipApplication implements InputFilterAwareInterface {
    /**
     * Form values.
     */
    private $id;
    private $firstname;
    private $surname;
    private $email;
    private $phone;
    private $address1;
    private $address2;
    private $city;
    private $postcode;
    private $medicalconditions;
    private $medicaldetails;
    private $emergencyname;
    private $emergencynumber;
    private $boat1class;
    private $boat1number;
    private $boat1owned;
    private $boat2class;
    private $boat2number;
    private $boat2owned;
    private $applicationplan;
    private $paymentplan;
    private $captcha;
    private $submit;

    /**
     * Populates object from array data.
     */
    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : NULL;
        $this->contactname = !empty($data['contactname']) ? $data['contactname'] : NULL;
        $this->email = !empty($data['email']) ? $data['email'] : NULL;
        $this->phone = !empty($data['phone']) ? $data['phone'] : NULL;
        $this->address1 = !empty($data['address1']) ? $data['address1'] : NULL;
        $this->address2 = !empty($data['address2']) ? $data['address2'] : NULL;
        $this->city = !empty($data['city']) ? $data['city'] : NULL;
        $this->postcode = !empty($data['postcode']) ? $data['postcode'] : NULL;
        $this->medicalconditions = !empty($data['medicalconditions']) ? $data['medicalconditions'] : NULL;
        $this->medicaldetails = !empty($data['medicaldetails']) ? $data['medicaldetails'] : NULL;
        $this->emergencyname = !empty($data['emergencyname']) ? $data['emergencyname'] : NULL;
        $this->emergencynumber = !empty($data['emergencynumber']) ? $data['emergencynumber'] : NULL;
        $this->boat1class = !empty($data['boat1class']) ? $data['boat1class'] : NULL;
        $this->boat1number = !empty($data['boat1number']) ? $data['boat1number'] : NULL;
        $this->boat1owned = !empty($data['boat1owned']) ? $data['boat1owned'] : NULL;
        $this->boat2class = !empty($data['boat2class']) ? $data['boat2class'] : NULL;
        $this->boat2number = !empty($data['boat2number']) ? $data['boat2number'] : NULL;
        $this->boat2owned = !empty($data['boat2owned']) ? $data['boat2owned'] : NULL;
        $this->applicationplan = !empty($data['applicationplan']) ? $data['applicationplan'] : NULL;
        $this->paymentplan = !empty($data['paymentplan']) ? $data['paymentplan'] : NULL;
        $this->captcha = !empty($data['captcha']) ? $data['captcha'] : NULL;
        $this->submit = !empty($data['submit']) ? $data['submit'] : NULL;
    }

    /**
     * Invalid. Does not support new input filters. The input filter comes from the $this->getInputFilter() function.
     */
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    /**
     * Generates a new input filter if an existing one has not been set from a previous function call.
     */
    public function getInputFilter() {
        if (property_exists($this, 'inputFilter')) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        // contactname
        $inputFilter->add([
            'name' => 'contactname',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 2,
                        'max' => 50,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        // email
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\EmailAddress::class,
                ],
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // phone
        $inputFilter->add([
            'name' => 'phone',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\Digits::class,
                ],
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // address1
        $inputFilter->add([
            'name' => 'address1',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 2,
                        'max' => 50,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        // city
        $inputFilter->add([
            'name' => 'city',
            'required' => false,
            'validators' => [
                [
                    'name' => Validator\StringLength::class,
                    'options' => [
                        'min' => 2,
                        'max' => 50,
                        'encoding' => 'UTF-8',
                    ],
                ],
            ],
        ]);

        // postcode
        $inputFilter->add([
            'name' => 'postcode',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // emergency contact name
        $inputFilter->add([
            'name' => 'emergencyname',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // emergency contact number
        $inputFilter->add([
            'name' => 'emergencynumber',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    /**
     * TODO Returns a human readable summary string of the data.
     */
    public function toString() {
        define('EOL', '<br>');
        define('YES', 'Yes');
        define('NO', 'No');

        if ($this->contactname != NULL) {              $str  = "Contact name: " . $this->contactname . EOL; } // Contact name
        if ($this->email != NULL) {                  $str .= "Email: " . $this->email . EOL; } // Email
        if ($this->address1 != NULL) {               $str .= "Address: " . EOL; } // Address
        if ($this->address1 != NULL) {               $str .= $this->address1 . EOL; } // Address
        if ($this->address2 != NULL) {               $str .= $this->address2 . EOL; } // Address
        if ($this->city != NULL) {                   $str .= $this->city . EOL; } // Address
        if ($this->postcode != NULL) {               $str .= $this->postcode . EOL; } // Address
        if ($this->medicalconditions != NULL) {      $str .= "Medical conditions: " . ($this->medicalconditions != NULL ? YES : NO) . EOL; } // Medical conditions
        if ($this->medicaldetails != NULL) {         $str .= "Medical details: " . $this->medicaldetails . EOL; } // Medical details
        if ($this->emergencyname != NULL) {          $str .= "Emergency name: " . $this->emergencyname . EOL; } // Emergency name
        if ($this->emergencynumber != NULL) {        $str .= "Emergency number: " . $this->emergencynumber . EOL; } // Emergency number

        return $str;
    }
}