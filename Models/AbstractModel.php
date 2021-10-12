<?php
/*
 * This file is part of the Nigatedev PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
 
namespace Nigatedev\FrameworkBundle\Models;

/**
 * Abstract model
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
abstract class AbstractModel {
    
    public array $errors = [];
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MAX = "max";
    public const RULE_MIN = "min";
    public const RULE_MATCH = "match";
    
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    
    /**
     * @return array
     */
    public abstract function rules(): array;
    
    /**
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }
                
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule["min"]) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }
                
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                
                if ($ruleName === self::RULE_MATCH && $value != $this->{$rule["match"]}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }
    
    /**
     * Add new field error
     * 
     * @param string $attribute
     * @param string $rule
     * @param string[] $params
     * 
     * @return void
     */
   public function addError(string $attribute, string $rule, array $params = [])
   {
       $message = $this->errorMessages()[$rule] ?? "";
       foreach ($params as $key => $value) {
           $message = str_replace("{{$key}}", $value, $message);
       }
       $this->errors[$attribute][] = $message;
   }
   
   /**
    * Errors message
    * @return string[]
    */
    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED     => 'This field is mandatory',
            self::RULE_EMAIL        => 'This field must be a valid email address',
            self::RULE_MIN          => 'The min length of this field must be {min}.',
            self::RULE_MAX          => 'The max length of this field must be {max}',
            self::RULE_MATCH        => 'This field must be the same as the {match} field.',
        ];
    }
    
    /**
     * @param string $attribute
     * @return string|bool
     */
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    
    /**
     * @param string $attribute
     * @return string
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? "";
    }
}