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
 * The default Model for user registration
 */
class UserRegisterModel extends AbstractModel
{
    
    /**
     * @var string
     */
    public string $firstname = '';
    
    /**
     * @var string
     */
    public string $lastname = '';
    
    /**
     * @var string
     */
    public string $email = '';
    
    /**
     * @var string
     */
    public string $password = '';
    
    /**
     * @var string
     */
    public string $passwordrepeat = '';
    
    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, "min" => 8], [self::RULE_MAX, "max" => 24]],
            "passwordrepeat" => [self::RULE_REQUIRED, [self::RULE_MATCH, "match" => "password"]],
        ];
    }
}
