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

        // Image
        $this->add([
            'type' => File::class,
            'name' => 'profileimage',
            'options' => [
                'label' => 'Upload a new profile picture',
            ],
            'attributes' => [
                'id' => 'profileimage',
                'required' => 'required',
                'placeholder' => 'YOU.jpg',
                'class' => 'w-100',
            ],
        ]);

        // submit button
        $this->add([
            'type' => Submit::class,
            'name' => 'submit',
            'attributes' => [
                'value' => 'Upload Image',
                'class' => 'btn btn-primary btn-sm',
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