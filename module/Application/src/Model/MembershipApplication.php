<?php
namespace Application\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilter\Input;
use Laminas\Validator;

class MembershipApplication implements InputFilterAwareInterface {
    /**
     * Form values.
     */
    private $id;
    private $firstname;
    private $surname;
    private $email;
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
    private $firstaid;
    private $firstaidexpire;
    private $existingqualifications;
    private $oodcheck;
    private $photocheck;
    private $insurancecheck;
    private $clubtccheck;
    private $newmember;
    private $tataemployee;
    private $tataemployeenumber;
    private $membershipplanemployee;
    private $membershipplannonemployee;
    private $paymentplan;
    private $captcha;
    private $submit;

    /**
     * Populates object from array data.
     */
    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : NULL;
        $this->firstname = !empty($data['firstname']) ? $data['firstname'] : NULL;
        $this->surname = !empty($data['surname']) ? $data['surname'] : NULL;
        $this->email = !empty($data['email']) ? $data['email'] : NULL;
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
        $this->firstaid = !empty($data['firstaid']) ? $data['firstaid'] : NULL;
        $this->firstaidexpire = !empty($data['firstaidexpire']) ? $data['firstaidexpire'] : NULL;
        $this->existingqualifications = !empty($data['existingqualifications']) ? $data['existingqualifications'] : NULL;
        $this->oodcheck = !empty($data['oodcheck']) ? $data['oodcheck'] : NULL;
        $this->photocheck = !empty($data['photocheck']) ? $data['photocheck'] : NULL;
        $this->insurancecheck = !empty($data['insurancecheck']) ? $data['insurancecheck'] : NULL;
        $this->clubtccheck = !empty($data['clubtccheck']) ? $data['clubtccheck'] : NULL;
        $this->newmember = !empty($data['newmember']) ? $data['newmember'] : NULL;
        $this->tataemployee = !empty($data['tataemployee']) ? $data['tataemployee'] : NULL;
        $this->tataemployeenumber = !empty($data['tataemployeenumber']) ? $data['tataemployeenumber'] : NULL;
        $this->membershipplanemployee = !empty($data['membershipplanemployee']) ? $data['membershipplanemployee'] : NULL;
        $this->membershipplannonemployee = !empty($data['membershipplannonemployee']) ? $data['membershipplannonemployee'] : NULL;
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

        // firstname
        $inputFilter->add([
            'name' => 'firstname',
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

        // surname
        $inputFilter->add([
            'name' => 'surname',
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

        // boat1class
        $inputFilter->add([
            'name' => 'boat1class',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // boat1number
        $inputFilter->add([
            'name' => 'boat1number',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\NotEmpty::class,
                ],
            ],
        ]);

        // paymentplan
        $inputFilter->add([
            'name' => 'paymentplan',
            'required' => true,
            'validators' => [
                [
                    'name' => Validator\Notempty::class,
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }

    /**
     * Returns a human readable summary string of the data.
     */
    public function toString() {
        define('EOL', '<br>');
        define('YES', 'Yes');
        define('NO', 'No');

        if ($this->firstname != NULL) {              $str  = "Name: " . $this->firstname . " " . $this->surname . EOL; } // Full name
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
        if ($this->boat1class != NULL) {             $str .= "Boat 1 class: " . $this->boat1class . EOL; } // Boat 1 class
        if ($this->boat1number != NULL) {            $str .= "Boat 1 number: " . $this->boat1number . EOL; } // Boat 1 number
        if ($this->boat1class != NULL) {             $str .= "Boat 1 owned: " . ($this->boat1owned != NULL ? YES : NO) . EOL; } // Boat 1 owned
        if ($this->boat2class != NULL) {             $str .= "Boat 2 class: " . $this->boat2class . EOL; } // Boat 2 classs
        if ($this->boat2number != NULL) {            $str .= "Boat 2 number: " . $this->boat2number . EOL; } // Boat 2 number
        if ($this->boat2class != NULL) {             $str .= "Boat 2 owned: " . ($this->boat2owned != NULL ? YES : NO) . EOL; } // Boat 2 owned
        if ($this->firstaid != NULL) {               $str .= "First aid certificate: " . ($this->firstaid != NULL ? YES : NO) . EOL; } // First aid
        if ($this->firstaidexpire != NULL) {         $str .= "First aid expire: " . $this->firstaidexpire . EOL; } // First aid expiry date
        if ($this->existingqualifications != NULL) { $str .= "Existing qualifications: " . $this->existingqualifications . EOL; } // Existing qualifications
        if ($this->newmember != NULL) {              $str .= "New member: " . ($this->newmember != NULL ? YES : NO) . EOL; } // New member
        if ($this->tataemployee != NULL) {           $str .= "Tata employee: " . ($this->tataemployee != NULL ? YES : NO) . EOL; } // Tata steel employee
        if ($this->tataemployeenumber != NULL) {     $str .= "Tata employee number: " . $this->tataemployeenumber . EOL; } // Tata steel employee number
        if ($this->tataemployee != NULL) {           $str .= "Membership plan: " . $this->membershipplanemployee . EOL; } // Membership plan (employee)
        else {                                       $str .= "Membership plan: " . $this->membershipplannonemployee . EOL; } // Membership plan (non-employee)
        if ($this->paymentplan != NULL) {            $str .= "Payment plan: " . $this->paymentplan . EOL; } // Payment plan

        return $str;
    }
}