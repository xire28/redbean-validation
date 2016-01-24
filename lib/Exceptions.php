<?php namespace RedbeanValidation;
/**
 * @package RedbeanValidation
 */

/**
 * Generic base exception for all ActiveRecord specific errors.
 *
 * @package RedbeanValidation
 */
class ActiveRecordException extends \Exception {}

/**
 * Thrown for validations exceptions.
 *
 * @package RedbeanValidation
 */
class ValidationsArgumentError extends ActiveRecordException {}