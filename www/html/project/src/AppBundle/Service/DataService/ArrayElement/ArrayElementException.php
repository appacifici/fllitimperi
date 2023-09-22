<?php namespace AppBundle\Service\SportradarDataService\ArrayElement;

class ArrayElementException extends \Exception
{
    /**
     * Codes
     */
    const CODE_KEY_NOT_FOUND            = 1;
    const CODE_KEY_ATTRIBUTES_NOT_FOUND = 10;
    const CODE_KEY_NAME_NOT_FOUND       = 11;
    const CODE_KEY_VALUE_NOT_FOUND      = 12;

    const CODE_PARENT                       = 2;
    const CODE_PARENT_NOT_FOUND             = 20;
    const CODE_PARENT_ID                    = 21;
    const CODE_PARENT_ID_NOT_PROVIDED       = 210;
    const CODE_PARENT_ID_DOES_NOT_EXISTS    = 211;
    const CODE_PARENT_NAME                  = 22;
    const CODE_PARENT_NAME_NOT_PROVIDED     = 220;
    const CODE_PARENT_NAME_DOES_NOT_EXISTS  = 221;
    const CODE_PARENT_PERSIST               = 23;

    const CODE_CUSTOM_PERSIST           = 3;

    /**
     * Messages
     */

    const MESSAGE_KEY_NOT_FOUND             = 'Key not found';
    const MESSAGE_KEY_ATTRIBUTES_NOT_FOUND  = 'The attributes key doesn\'t exists in the array';
    const MESSAGE_KEY_NAME_NOT_FOUND        = 'The name key doesn\'t exists in the array';
    const MESSAGE_KEY_VALUE_NOT_FOUND       = 'The value key doesn\'t exists in the array';

    const MESSAGE_PARENT_NOT_FOUND              = 'The parent entity has not been found';
    const MESSAGE_PARENT_ID_NOT_PROVIDED        = 'The parent Id has not been provided';
    const MESSAGE_PARENT_ID_DOES_NOT_EXISTS     = 'The parent entity for the given Id has not been found';
    const MESSAGE_PARENT_NAME_NOT_PROVIDED      = 'The parent name has not been provided';
    const MESSAGE_PARENT_NAME_DOES_NOT_EXISTS   = 'The given parent name doesn\'t match with the EntityLayers available';
    const MESSAGE_PARENT_PERSIST                = 'Error while persisting the Entity';

    const MESSAGE_CUSTOM_PERSIST = 'Custom persist method has failed';

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }

    /**
     * Provides a string representation of the Exception
     * @return string The {Code}: {Message} representation of the thrown exception
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
