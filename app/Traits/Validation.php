<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 1.03.2018
 * Time: 15:38
 */

namespace App\Traits;

use Sirius\Validation\Validator;

trait Validation
{
    /**
     * Return validation messages
     *
     * @param \Sirius\Validation\Validator $validator
     *
     * @return array
     */
    public function getValidationMessages(Validator $validator)
    {
        $messages = [];

        foreach ($validator->getMessages() as $rule => $message) {
            /** @var \Sirius\Validation\ErrorMessage $item */
            foreach ($message as $item) {
                $messages[$rule] = (string)$item;
            }
        }

        return $messages;
    }
}