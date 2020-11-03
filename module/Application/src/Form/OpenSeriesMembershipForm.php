<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Textarea as TextArea;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\DateSelect;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Tel;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\Captcha;
use Laminas\Captcha\ReCaptcha as ReCaptcha;

class OpenSeriesMembershipForm extends Form {
    /**
     * Declaration terms and condition about photographs.
     */
    const PHOTO_TOC_DEC = "I consent for my images to be used by the Club. Family members will need to sign a <a href='/docs/gdprForm.pdf' target='_blank'>consent form</a> <i class='fa fa-info-circle'></i>";

    const PHOTO_TOC_DEC_TOOLTIP = "The Club may arrange for photographs or videos to be taken of Club activities and published on our website or social media channels to promote the Club. Image consent can be withdrawn by contacting the Membership Secretary. Any Image already published can be removed at any time by request";

    /**
     * Declaration terms and condition about insurance.
     */
    const INSURANCE_TOC_DEC = "All craft are to be insured for a minimum of £3M for third Party Risks";

    /**
     * Declaration terms and condition for club T&Cs .
     */
    const CLUB_TOC_DEC = "I understand and accept the <a href='/terms-and-conditions' target='_blank'>Club's Terms, Conditions and Policies</a>";

    public function __construct($name = null, $recaptchaOptions) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => Hidden::class,
            'name' => 'id',
        ]);

        /**
         * Personal Details
         */
        // First Name
        $this->add([
            'type' => Text::class,
            'name' => 'firstname',
            'options' => [
                'label' => 'First Name*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'John',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Surname
        $this->add([
            'type' => Text::class,
            'name' => 'surname',
            'options' => [
                'label' => 'Surname*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Smith',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Email
        $this->add([
            'type' => Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'you@email.com',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Phone
        $this->add([
            'type' => Tel::class,
            'name' => 'phone',
            'options' => [
                'label' => 'Phone Number*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => '07123 456 789',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Address Line 1
        $this->add([
            'type' => Text::class,
            'name' => 'address1',
            'options' => [
                'label' => 'Address*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Address Line 1',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Address Line 2
        $this->add([
            'type' => Text::class,
            'name' => 'address2',
            'options' => [
                'label' => 'Address Line 2',
            ],
            'attributes' => [
                'placeholder' => 'Address Line 2',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // City
        $this->add([
            'type' => Text::class,
            'name' => 'city',
            'options' => [
                'label' => 'City',
            ],
            'attributes' => [
                'placeholder' => 'City',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Post Code
        $this->add([
            'type' => Text::class,
            'name' => 'postcode',
            'options' => [
                'label' => 'Post Code',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Post Code',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        /**
         * Emergency Information
         */
        // Medical Conditions
        $this->add([
            'type' => Checkbox::class,
            'name' => 'medicalconditions',
            'options' => [
                'label' => 'I Have Medical Conditions',
                'label_attributes' => [
                    'class' => 'form-check-label'
                ],
            ],
            'attributes' => [
                'placeholder' => 'Medical Conditions',
                'class' => 'form-check-input',
                'id' => 'medicalconditions',
                'data-toggle'    => 'tooltip',
                'data-placement' => 'left',
                'title'          => 'Select if you have an existing medical condition that we should know about',
            ],
        ]);

        // Medical Details
        $this->add([
            'type' => TextArea::class,
            'name' => 'medicaldetails',
            'options' => [
                'label' => 'Medical Details',
            ],
            'attributes' => [
                'placeholder' => 'Please Specify',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Emergency Contact Name
        $this->add([
            'type' => Text::class,
            'name' => 'emergencyname',
            'options' => [
                'label' => 'Emergency Contact Name',
            ],
            'attributes' => [
                'placeholder' => 'Emergency Contact Name',
                'class' => 'form-control input-group mb-3',
                'data-toggle'    => 'tooltip',
                'data-placement' => 'left',
                'title'          => 'We will contact this person in the event of a medical emergency',
            ],
        ]);

        // Emergency Contact Number
        $this->add([
            'type' => Tel::class,
            'name' => 'emergencynumber',
            'options' => [
                'label' => 'Emergency Contact Number',
            ],
            'attributes' => [
                'placeholder' => '07123 456 789',
                'class' => 'form-control input-group mb-3',
                'type' => 'tel',
                'data-toggle'    => 'tooltip',
                'data-placement' => 'left',
                'title'=> 'We will contact this person in the event of a medical emergency',
            ],
        ]);

        /**
         * Boats
         */
        // Boat 1 Class
        $this->add([
            'type' => Text::class,
            'name' => 'boat1class',
            'options' => [
                'label' => 'Boat 1 Class*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Boat 1 Class',
                'class' => 'form-control input-group mb-3',
                'data-toggle'    => 'tooltip',
                'data-placement' => 'left',
                'title'          => 'The class of your boat, e.g \'Osprey\'',
            ],
        ]);

        // Boat 1 Number
        $this->add([
            'type' => Text::class,
            'name' => 'boat1number',
            'options' => [
                'label' => 'Boat 1 Number*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Boat 1 Number',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Boat 1 Owned
        $this->add([
            'type' => Checkbox::class,
            'name' => 'boat1owned',
            'options' => [
                'label' => 'I own this boat',
                'label_attributes' => [
                    'class' => 'form-check-label',
                    'data-toggle' => 'tooltip',
                    'title' => 'Check if you own this boat',
                ],
            ],
            'attributes' => [
                'placeholder' => 'I own this boat',
                'class' => 'form-check-input',
                'data-toggle' => 'tooltip',
                'title' => 'Check if you own this boat',
            ],
        ]);

        // Boat 2 Class
        $this->add([
            'type' => Text::class,
            'name' => 'boat2class',
            'options' => [
                'label' => 'Boat 2 Class',
            ],
            'attributes' => [
                'placeholder' => 'Boat Class',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Boat 2 Number
        $this->add([
            'type' => Text::class,
            'name' => 'boat2number',
            'options' => [
                'label' => 'Boat 2 Number',
            ],
            'attributes' => [
                'placeholder' => 'Boat 2 Number',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // Boat 2 Owned
        $this->add([
            'type' => Checkbox::class,
            'name' => 'boat2owned',
            'options' => [
                'label' => 'I own this boat',
                'label_attributes' => [
                    'class' => 'form-check-label',
                    'data-toggle'    => 'tooltip',
                    'title'          => 'Check if you own this boat',
                ],
            ],
            'attributes' => [
                'placeholder' => 'I own this boat',
                'class' => 'form-check-input',
                'data-toggle'    => 'tooltip',
                'title'          => 'Check if you own this boat',
            ],
        ]);

        /**
         * Terms and Conditions
         */
        // Photograhs Checkbox
        $this->add([
            'type' => Checkbox::class,
            'name' => 'photocheck',
            'options' => [
                'label' => self::PHOTO_TOC_DEC,
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label_attributes' => [
                    'class' => 'form-check-label',
                    'data-toggle' => 'tooltip',
                    'title' => self::PHOTO_TOC_DEC_TOOLTIP,
                ],
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Photographs',
                'class' => 'form-check-input',
                'data-toggle' => 'tooltip',
                'title' => self::PHOTO_TOC_DEC_TOOLTIP,
            ],
        ]);

        // Insurance Checkbox
        $this->add([
            'type' => Checkbox::class,
            'name' => 'insurancecheck',
            'options' => [
                'label' => self::INSURANCE_TOC_DEC,
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label_attributes' => [
                    'class' => 'form-check-label'
                ],
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Insurance',
                'class' => 'form-check-input',
            ],
        ]);

        // Club's terms Checkbox
        $this->add([
            'type' => Checkbox::class,
            'name' => 'clubtccheck',
            'options' => [
                'label' => self::CLUB_TOC_DEC,
                'label_options' => [
                    'disable_html_escape' => true,
                ],
                'label_attributes' => [
                    'class' => 'form-check-label'
                ],
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Club Terms and Conditions',
                'class' => 'form-check-input',
            ],
        ]);

        /**
         * Application Plan
         */
        // application plan
        $this->add([
            'type' => Select::class,
            'name' => 'applicationplan',
            'options' => [
                'label' => 'Select Autumn/Winter Open participation plan*',
                'unselected_value' => 0,
                'value_options' => [
                    '0' => [
                        'label' => 'Family (yourself, partner, all children under 18) - £70',
                        'value' => 70,
                    ],
                    '1' => [
                        'label' => 'Single adult (18 - 64 years of age at 1st Jan this year) - £60',
                        'value' => 60,
                    ],
                    '2' => [
                        'label' => 'Single adult (65 and over) - £44',
                        'value' => 44,
                    ],
                    '3' => [
                        'label' => 'Student / apprentice  (18 or over at 1st Jan this year) - £24',
                        'value' => 24,
                    ],
                    '4' => [
                        'label' => 'Junior (Not yet 18 at 1st Jan this year) - £15',
                        'value' => 15,
                    ],
                    '5' => [
                        'label' => 'Crew (non-boat owning adult) - £24',
                        'value' => 24,
                    ],
                ],
            ],
            'attributes' => [
                'placeholder' => 'Application Plan',
                'class' => 'form-control input-group mb-3',
                'id' => 'applicationplan',
            ],
        ]);

        // payment plan
        $this->add([
            'type' => Select::class,
            'name' => 'paymentplan',
            'options' => [
                'label' => 'Select Payment Plan*',
                'empty_option' => 'Please select...',
                'value_options' => [
                    '0' => [
                        'label' => 'I will write a cheque',
                        'value' => 'cheque',
                    ],
                    '1' => [
                        'label' => 'I will pay the above amount via Bank Transfer',
                        'value' => 'bank',
                    ],
                ],
            ],
            'attributes' => [
                'placeholder' => 'Your Tata Steel Employee Number',
                'class' => 'form-control input-group mb-3',
                'id' => 'paymentplan',
            ],
        ]);

        // captcha
        $this->add([
            'type' => Element\Captcha::class,
            'name' => 'captcha',
            'options' => [
                'label' => 'Please verify you are human',
                'captcha' => new ReCaptcha($recaptchaOptions),
            ],
            'attributes' => [
                'required' => 'required',
            ],
        ]);

        // submit button
        $this->add([
            'type' => Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary btn-lg d-flex mx-auto',
            ],
        ]);
    }
}