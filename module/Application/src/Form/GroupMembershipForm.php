<?php
namespace Application\Form;

use Laminas\Form\Element;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Textarea as TextArea;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Button;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\DateSelect;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Tel;
use Laminas\Form\Element\Number;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\Captcha;
use Laminas\Captcha\ReCaptcha as ReCaptcha;

class GroupMembershipForm extends Form {
    /**
     * How long a first aid certificate is assumed to last.
     * This is added to the current year to give the maximum expiry date.
     */
    const FIRST_AID_LIFETIME = 5;

    /**
     * Declaration terms and condition about OOD duty.
     */
    CONST OOD_TOC_DEC = "
        I/we commit to provide three dates on which I/we are able to do OOD duties during the year via the online roster in the Tata Steel Sailing Club website.
        If you are unsure about OOD duties, put yourself down as 'Officer 2' or 'Support'";

    /**
     * Declaration terms and condition about photographs.
     */
    const PHOTO_TOC_DEC = "I understand and accept that the Club may arrange for promotional photographs or videos to be taken of Club activities and published on our website or social media channels.";

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
         * Organisation Details
         */
        // contactname
        $this->add([
            'type' => Text::class,
            'name' => 'contactname',
            'options' => [
                'label' => 'Contact Full Name*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'e.g. Swansea University Windsurfers',
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
                'label' => 'Contact Phone*',
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
                'label' => 'Check this box if anyone in your organisation has a medical condition you need us to know about',
                'label_attributes' => [
                    'class' => 'form-check-label'
                ],
            ],
            'attributes' => [
                'placeholder' => 'Medical Conditions',
                'class' => 'form-check-input',
                'id' => 'medicalconditions',
                'data-toggle' => 'tooltip',
                'data-placement' => 'left',
                'title' => 'Check this box if anyone in your organisation has a medical condition you need us to know about',
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
                'label' => 'Emergency Contact Name*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Emergency Contact Name',
                'class' => 'form-control input-group mb-3',
                'data-toggle' => 'tooltip',
                'data-placement' => 'left',
                'title' => 'We will contact this person in the event of a medical emergency',
            ],
        ]);

        // Emergency Contact Number
        $this->add([
            'type' => Tel::class,
            'name' => 'emergencynumber',
            'options' => [
                'label' => 'Emergency Contact Number*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => '07123 456 789',
                'class' => 'form-control input-group mb-3',
                'type' => 'tel',
                'data-toggle'    => 'tooltip',
                'data-placement' => 'left',
                'title'=> 'We will contact this person in the event of a medical emergency',
            ],
        ]);

        /**
         * Leaders/Instructors
         */
        // lead 1 name
        $this->add([
            'type' => Text::class,
            'name' => 'lead1name',
            'options' => [
                'label' => 'Leader name*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'John Smith',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // add a leader button
        $this->add([
            'type' => Button::class,
            'name' => 'addLeader',
            'options' => [
                'label' => '<i class="fa fa-user-plus"></i> New Leader',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            'attributes' => [
                'placeholder' => 'John Smith',
                'class' => 'btn btn-sm btn-primary',
                'id' => 'addLeader',
            ],
        ]);

        // remove a leader button
        $this->add([
            'type' => Button::class,
            'name' => 'removeLeader',
            'options' => [
                'label' => '<i class="fa fa-user-minus"></i>',
                'label_options' => [
                    'disable_html_escape' => true,
                ],
            ],
            'attributes' => [
                'placeholder' => 'Remove Leader',
                'class' => 'btn btn-sm btn-primary',
                'id' => 'removeLeader',
            ],
        ]);

        /**
         * Group Numbers
         */
        // number of people using the club at once
        $this->add([
            'type' => Number::class,
            'name' => 'numusingclub',
            'options' => [
                'label' => 'Number of people using the club at any one time*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // number of boats in the compound/on the water at once
        $this->add([
            'type' => Number::class,
            'name' => 'numboats',
            'options' => [
                'label' => 'Maximum number of boats in Compound/On water at any one time*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // average number of days a week then faclilities will be used
        $this->add([
            'type' => Number::class,
            'name' => 'numdays',
            'options' => [
                'label' => 'Average number of days a week the facilities will be used*',
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        /**
         * Additional Hire Requirements
         */
        // num double handed dinghy
        $this->add([
            'type' => Number::class,
            'name' => 'numdoubledinghy',
            'options' => [
                'label' => 'Double Handed Dinghy',
            ],
            'attributes' => [
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // num single handed dinghy
        $this->add([
            'type' => Number::class,
            'name' => 'numsingledinghy',
            'options' => [
                'label' => 'Single Handed Dinghy',
            ],
            'attributes' => [
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // num windsurfing boards
        $this->add([
            'type' => Number::class,
            'name' => 'numwindsurfingboards',
            'options' => [
                'label' => 'Windsurfing Boards',
            ],
            'attributes' => [
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
            ],
        ]);

        // numsupport powerboats
        $this->add([
            'type' => Number::class,
            'name' => 'numpowerboat',
            'options' => [
                'label' => 'Support Powerboat',
            ],
            'attributes' => [
                'placeholder' => '0',
                'class' => 'form-control input-group mb-3',
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
                    'class' => 'form-check-label'
                ],
            ],
            'attributes' => [
                'required' => 'required',
                'placeholder' => 'Photographs',
                'class' => 'form-check-input',
                'data-toggle'    => 'tooltip',
                'title'          => self::PHOTO_TOC_DEC_TOOLTIP,
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

    /**
     * Retrieve the validated data
     *
     * By default, retrieves normalized values; pass one of the
     * FormInterface::VALUES_* constants to shape the behavior.
     *
     * @param  int $flag
     * @return array|object
     * @throws Exception\DomainException
     */
    public function getData($flag = FormInterface::VALUES_NORMALIZED) {
        if (! $this->hasValidated) {
            throw new Exception\DomainException(sprintf(
                '%s cannot return data as validation has not yet occurred',
                __METHOD__
            ));
        }

        $this->preValidation();

        return parent::getData($flag);
    }

    /**
     * After post, pre validation hook
     * 
     * Finds all fields where name includes 'newName' and uses addNewLeaderField() to add
     * them to the form object
     * 
     * @param array $data $_GET or $_POST
     */
    public function preValidation(array $data) {
        // array_filter callback
        function findFields($field) {
            // return field names that include 'newName'
            if (strpos($field, 'newName') !== false) {
                return $field;
            }
        }

        // Search $data for dynamically added fields using findFields callback
        $newFields = array_filter(array_keys($data), 'findFields');

        foreach ($newFields as $fieldName) {
            // strip the id number off of the field name and use it to set new order
            $order = ltrim($fieldName, 'newName') + 2;
            $this->addNewLeaderField($fieldName, $data[$fieldName], $order);
        }
    }

    /**
     * Adds new fields to form
     *
     * @param string $name
     * @param string $value
     * @param int    $order
     */
    public function addNewLeaderField($name, $value, $order) {
        $this->add([
            'type' => Text::class,
            'name' => 'additionalleadname',
            'options' => [
                'label' => 'Leader name',
            ],
            'attributes' => [
                'placeholder' => 'John Smith',
                'class' => 'form-control input-group mb-3',
            ],
        ]);
    }
}