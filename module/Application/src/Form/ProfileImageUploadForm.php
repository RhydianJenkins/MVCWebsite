<?php
namespace Application\Form;

use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\File;
use Laminas\Form\Element\Submit;
use Laminas\Validator\File\IsImage;
use Laminas\InputFilter\InputFilter;
use Laminas\Form\Form;

class ProfileImageUploadForm extends Form {
    public function __construct($name = null) {
        parent::__construct($name);

        // hidden ID
        $this->add([
            'type' => Hidden::class,
            'name' => 'id',
        ]);

        // File upload
        $this->add([
            'type' => File::class,
            'name' => 'profileimage',
            'options' => [
                'label' => 'Upload a new picture',
                'label_attributes' => [
                    'for' => 'profileimage',
                ],

            ],
            'attributes' => [
                'type' => 'file',
                'class' => 'mw-100',
                'id' => 'profileimage',
                'required' => 'required',
            ],
        ]);

        // submit button
        $this->add([
            'type' => Submit::class,
            'name' => 'submit',
            'disable_escape_html' => true,
            'attributes' => [
                'value' => 'Upload',
                'class' => '',
            ],
        ]);
    }

    public function getInputFilter() {
        if (property_exists($this, 'inputFilter')) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        // firstname
        $inputFilter->add([
            'name' => 'profileimage',
            'required' => true,
            'validators' => [['name' => IsImage::class]],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}