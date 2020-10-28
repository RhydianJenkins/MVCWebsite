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
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->firstname = !empty($data['firstname']) ? $data['firstname'] : null;
        $this->surname = !empty($data['surname']) ? $data['surname'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->address1 = !empty($data['address1']) ? $data['address1'] : null;
        $this->address2 = !empty($data['address2']) ? $data['address2'] : null;
        $this->city = !empty($data['city']) ? $data['city'] : null;
        $this->postcode = !empty($data['postcode']) ? $data['postcode'] : null;
        $this->medicalconditions = !empty($data['medicalconditions']) ? $data['medicalconditions'] : null;
        $this->medicaldetails = !empty($data['medicaldetails']) ? $data['medicaldetails'] : null;
        $this->emergencyname = !empty($data['emergencyname']) ? $data['emergencyname'] : null;
        $this->emergencynumber = !empty($data['emergencynumber']) ? $data['emergencynumber'] : null;
        $this->boat1class = !empty($data['boat1class']) ? $data['boat1class'] : null;
        $this->boat1number = !empty($data['boat1number']) ? $data['boat1number'] : null;
        $this->boat1owned = !empty($data['boat1owned']) ? $data['boat1owned'] : null;
        $this->boat2class = !empty($data['boat2class']) ? $data['boat2class'] : null;
        $this->boat2number = !empty($data['boat2number']) ? $data['boat2number'] : null;
        $this->boat2owned = !empty($data['boat2owned']) ? $data['boat2owned'] : null;
        $this->firstaid = !empty($data['firstaid']) ? $data['firstaid'] : null;
        $this->firstaidexpire = !empty($data['firstaidexpire']) ? $data['firstaidexpire'] : null;
        $this->existingqualifications = !empty($data['existingqualifications']) ? $data['existingqualifications'] : null;
        $this->oodcheck = !empty($data['oodcheck']) ? $data['oodcheck'] : null;
        $this->photocheck = !empty($data['photocheck']) ? $data['photocheck'] : null;
        $this->insurancecheck = !empty($data['insurancecheck']) ? $data['insurancecheck'] : null;
        $this->clubtccheck = !empty($data['clubtccheck']) ? $data['clubtccheck'] : null;
        $this->newmember = !empty($data['newmember']) ? $data['newmember'] : null;
        $this->tataemployee = !empty($data['tataemployee']) ? $data['tataemployee'] : null;
        $this->tataemployeenumber = !empty($data['tataemployeenumber']) ? $data['tataemployeenumber'] : null;
        $this->membershipplanemployee = !empty($data['membershipplanemployee']) ? $data['membershipplanemployee'] : null;
        $this->membershipplannonemployee = !empty($data['membershipplannonemployee']) ? $data['membershipplannonemployee'] : null;
        $this->paymentplan = !empty($data['paymentplan']) ? $data['paymentplan'] : null;
        $this->captcha = !empty($data['captcha']) ? $data['captcha'] : null;
        $this->submit = !empty($data['submit']) ? $data['submit'] : null;
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
     * Prints a human readable string of the data.
     */
    public function toString() {
        $str = "First name: " . $this->firstname . PHP_EOL;
        $str .= "Surname: " . $this->surname . PHP_EOL;
        $str .= "Email: " . $this->email . PHP_EOL;
        $str .= "Address: " . PHP_EOL;
        $str .= $this->address1 . PHP_EOL;
        $str .= $this->address2 . PHP_EOL;
        $str .= $this->city . PHP_EOL;
        $str .= $this->postcode . PHP_EOL;
        $str .= "Medical conditions: " . $this->medicalconditions . PHP_EOL;
        $str .= "Medical details: " . $this->medicaldetails . PHP_EOL;
        $str .= "Emergency name: " . $this->emergencyname . PHP_EOL;
        $str .= "Emergency number: " . $this->emergencynumber . PHP_EOL;
        $str .= "Boat 1 class: " . $this->boat1class . PHP_EOL;
        $str .= "Boat 1 number: " . $this->boat1number . PHP_EOL;
        $str .= "Boat 1 owned: " . $this->boat1owned . PHP_EOL;
        $str .= "Boat 2 class: " . $this->boat2class . PHP_EOL;
        $str .= "Boat 2 number: " . $this->boat2number . PHP_EOL;
        $str .= "Boat 2 owned: " . $this->boat2owned . PHP_EOL;
        $str .= "First aid certificate: " . $this->firstaid . PHP_EOL;
        $str .= "First aid expire: " . $this->firstaidexpire . PHP_EOL;
        $str .= "Existing qualifications: " . $this->existingqualifications . PHP_EOL;
        $str .= "New member: " . $this->newmember . PHP_EOL;
        $str .= "Tata employee: " . $this->tataemployee . PHP_EOL;
        $str .= "Tata employee number: " . $this->tataemployeenumber . PHP_EOL;
        $str .= "Membership plan employee: " . $this->membershipplanemployee . PHP_EOL;
        $str .= "Membership plan nonemployee: " . $this->membershipplannonemployee . PHP_EOL;
        $str .= "Payment plan: " . $this->paymentplan . PHP_EOL;
        return $str;
    }
}