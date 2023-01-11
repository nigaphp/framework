<?php
/*
 * This file is part of the niga PHP framework package
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Niga\Framework\FormBuilder;

use Niga\Framework\Models\AbstractModel;

/**
 * Form fields
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Field
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var AbstractModel
     */
    public AbstractModel $model;

    public const TYPE_TEXT = "text";
    public const TYPE_EMAIL = "email";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";
    public const TYPE_CHECKBOX = "checkbox";
    public const TYPE_RADIOBOX = "radiobox";

    /**
     * Field constructor
     */
    public function __construct(AbstractModel $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
    }

    public function __toString()
    {

        return sprintf(
            '
            <div class="form-group">
                <label for="%s" class="form-label">%s</label>
                <input name="%s" value="%s" type="%s" id="%s" class="form-control%s">
                <div class="text-danger invalide-feedback">%s</div>
            </div>',
            $this->attribute,
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->type,
            $this->attribute,
            $this->model->hasError($this->attribute) ? " is-invalid" : "",
            $this->model->getFirstError($this->attribute)
        );
    }

    /**
     * HTML input type password
     *
     * @return self
     */
    public function passwordField(): self
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * HTML input type email
     *
     * @return self
     */
    public function emailField(): self
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    /**
     * HTML input type checkbox
     *
     * @return self
     */
    public function checkboxField(): self
    {
        $this->type = self::TYPE_CHECKBOX;
        return $this;
    }

    /**
     * HTML input type radiobox
     *
     * @return self
     */
    public function radioboxField(): self
    {
        $this->type = self::TYPE_RADIOBOX;
        return $this;
    }
}
