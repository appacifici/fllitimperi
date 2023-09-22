<?php namespace AppBundle\Entity;

class BetradarEntity {

    /**
     * The field which perform an existance check according to the proper reference on the received feed
     * @var string
     */
    protected $existanceField;

    /**
     * While persisting data, inject the SuperClass to let the related Entity perform an accurate existance check
     * @var boolean
     */
    protected $injectEntity;

    public function __construct($existanceField = '', $injectEntity = FALSE) {
        $this->existanceField   = $existanceField;
        $this->injectEntity     = $injectEntity;
    }

    /**
     * From a snake_case to a CamelCase string
     * @param  string $word The snake_case string
     * @return string       The snake_string converted in CamelCase
     */
    private function _camelize($word) {
        return preg_replace('/(^|_)([a-z])/e', 'strtoupper("\\2")', $word);
    }

    /**
     * From a CamelCase to a snake_case string
     * @param  string $word The CamelCase string
     * @return string       The CamelCase converted in snake_case
     */
    private function _decamelize($word) {
        return preg_replace(
            '/(^|[a-z])([A-Z])/e',
            'strtolower(strlen("\\1") ? "\\1_\\2" : "\\2")',
            $word
        );
    }

    /**
     * Returns the snaked case existance field name
     * @return string
     */
    public function getDecamelizedExistanceField() {
        return $this->_decamelize($this->existanceField);
    }

    /**
     * Returns the existance field name
     * @return string
     */
    public function getExistanceField() {
        return $this->existanceField;
    }

    /**
     * Tells if the current entity should be injected to perform an accurate existance check on the related entity
     * @return boolean TRUE if required, FALSE otherwise
     */
    public function injectEntity() {
        return $this->injectEntity;
    }
}
