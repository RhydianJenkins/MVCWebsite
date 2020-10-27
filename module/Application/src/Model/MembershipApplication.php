<?php
namespace Application\Model;

use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilter\Input;
use Laminas\Validator;

class MembershipApplication implements InputFilterAwareInterface {
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

    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->password = !empty($data['firstname']) ? $data['firstname'] : null;
        $this->email = !empty($data['surname']) ? $data['surname'] : null;
        $this->firstname = !empty($data['address1']) ? $data['address1'] : null;
        $this->address2 = !empty($data['address2']) ? $data['address2'] : null;
        $this->city = !empty($data['city']) ? $data['city'] : null;
        $this->postcode = !empty($data['postcode']) ? $data['postcode'] : null;
        $this->medicalconditions = !empty($data['medicalconditions']) ? $data['medicalconditions'] : null;
        $this->medicaldetails = !empty($data['medicaldetails']) ? $data['medicaldetails'] : null;
        $this->emergencyname = !empty($data['emergencyname']) ? $data['emergencyname'] : null;
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

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

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
                    ]
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
                    ]
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

    /**
     * Looks at the current data and calculates the cost of the application.
     */
    public function calculateCost() {

    }
}