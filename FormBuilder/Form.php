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
 
namespace Niga\Framework\FormBuilder;

use Niga\Framework\Models\AbstractModel;

/**
 * Main Form class
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Form
{
    /**
     * The opening tag of the form (e.g: <form>)
     * @param string $action     The action
     * @param string $method     The method get|post|delete...
     *
     * @return Form
     */
    public static function formStart(string $action = "", string $method = "get")
    {
        echo sprintf('<form action="%s" method="%s" class="g-3 mb-4 mt-4">', $action, $method);
    
        return new Form();
    }
    
    /**
     * The closing tag of the form     (e.g: </form>)
     *
     * @return string
     */
    public static function formEnd()
    {
        echo '</form>';
    }
    
    /**
     * Input field
     *
     * @param AbstractModel $model
     * @param string $attribute
     *
     * @return Field
     */
    public function field(AbstractModel $model, $attribute)
    {
        return new Field($model, $attribute);
    }
}
