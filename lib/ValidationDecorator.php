<?php namespace RedbeanValidation;

class ValidationDecorator extends Decorator {

    /**
     * An instance of {@link Errors} and will be instantiated once a write method is called.
     *
     * @var \RedbeanValidation\Errors
     */
    public $errors;
    static $pk = 'id';

    /**
     * Validates the model.
     *
     * @return boolean True if passed validators otherwise false
     */
    private function _validate()
    {
        $validator = new Validations($this);
        // need to store reference b4 validating so that custom validators have access to add errors
        $this->errors = $validator->get_record();
        $validator->validate();
        return $this->errors->is_empty();
    }

    /**
     * Run validations on model and returns whether or not model passed validation.
     *
     * @see is_invalid
     * @return boolean
     */
    public function is_valid()
    {
        return $this->_validate();
    }

    /**
     * Runs validations and returns true if invalid.
     *
     * @see is_valid
     * @return boolean
     */
    public function is_invalid()
    {
        return !$this->_validate();
    }

    /**
     * Returns array of validator data for this Model.
     *
     * Will return an array looking like:
     *
     * <code>
     * array(
     *   'name' => array(
     *     array('validator' => 'validates_presence_of'),
     *     array('validator' => 'validates_inclusion_of', 'in' => array('Bob','Joe','John')),
     *   'password' => array(
     *     array('validator' => 'validates_length_of', 'minimum' => 6))
     *   )
     * );
     * </code>
     *
     * @return array An array containing validator data for this model.
     */
    public function get_validation_rules()
    {
        $validator = new Validations($this);
        return $validator->rules();
    }

    /**
     * Retrieve the primary key name.
     *
     * @return string The primary key for the model
     */
    public function get_primary_key()
    {
        return self::$pk;
    }

    /**
     * Retrieves the name of the table for this Model.
     *
     * @return string
     */
    public function get_table_name()
    {
        return $this->object->getMeta('type');
    }
}