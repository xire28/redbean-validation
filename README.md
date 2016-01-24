# Redbean validation
Php-activerecord validations for redbean using decorators

## Requirements

- PHP >= 5.3.0

## Documentation

- [Php-activerecord validation documentation](http://www.phpactiverecord.org/projects/main/wiki/Validations)

## Install
### Using Composer

```
composer require xire28/redbean-validation
```

## Example

### Define a validation decorator

`UserValidationDecorator.php`

```
<?php
class UserValidationDecorator extends \RedbeanValidation\ValidationDecorator
{
    static $validates_length_of = [
        ['first_name', 'within' => [5, 20]],
        ['last_name', 'within' => [5, 20]]
    ];

    static $validates_uniqueness_of = [
		[['first_name', 'last_name'], 'message' => 'name already in use']
	];

    public function validate(){
        if ($this->first_name == $this->last_name)
        {
            $this->errors->add('first_name', "can't be the same as last name");
            $this->errors->add('last_name', "can't be the same as first name");
        }
    }
}
```

### Validate bean

`main.php`

```
$user = new UserValidationDecorator(R::dispense('user'));
$user->first_name = 'John';
$user->last_name = 'John';
if($user->is_valid()) 
{
	R::store($user->object);
}
else
{
	/* Handle validation errors */
	var_dump($user->errors);
}
```

### Result 

#### Note
- A "John John" user exists in the database (created without using validations)

```
object(RedbeanValidation\Errors)[17]
  private 'model' => null
  private 'errors' => 
    array (size=3)
      'first_name' => 
        array (size=2)
          0 => string 'is too short (minimum is 10 characters)' (length=39)
          1 => string 'can't be the same as last name' (length=30)
      'last_name' => 
        array (size=2)
          0 => string 'is too short (minimum is 10 characters)' (length=39)
          1 => string 'can't be the same as first name' (length=31)
      'first_name_and_last_name' => 
        array (size=1)
          0 => string 'name already in use' (length=19)
```    