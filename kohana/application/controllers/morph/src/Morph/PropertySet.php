<?php
/**
 * @package Morph
 * @author Jonathan Moss <xirisr@gmail.com>
 * @copyright Jonathan Moss 2009
 */

/**
 * Object to represent a set of properties
 *
 * @package Morph
 */
class  Morph_PropertySet extends ArrayObject
{

    /**
     * Get the value of the specified property within this set
     *
     * Returns null if $name does not exist in this set
     *
     * @param $name
     * @return mixed
     */
    public function getPropertyValue($name)
    {
        $value = null;
        if(isset($this[$name])){
            $value = $this[$name]->getValue();
        }
        return $value;
    }

    /**
     * Sets the value of the specified property
     *
     * @param $name
     * @param $value
     */
    public function setPropertyValue($name, $value)
    {
        if(isset($this[$name])){
            $this[$name]->setValue($value);
        }
    }

    /**
     * Get the raw value for the specified property
     *
     * returns null if $name is not set
     *
     * @param $name
     * @return mixed
     */
    public function __getRawPropertyValue($name)
    {
        $value = null;
        if(isset($this[$name])){
            $value = $this[$name]->__getRawValue();
        }
        return $value;
    }

    /**
     * Sets the raw value of the named property
     *
     *
     * @param $name
     * @param $value
     */
    public function __setRawPropertyValue($name, $value)
    {
        if(!isset($this[$name])){
            $this[$name] = new Morph_Property_Generic($name);
        }
        $this[$name]->__setRawValue($value);
    }

    /**
     * Sets the storage class for to use
     *
     * @param $storage
     * @return void
     */
    public function setStorage(Morph_Storage $storage)
    {
        foreach ($this as $property) {
            $property->setStorage($storage);
        }
    }

    // ARRAY ACCESS FUNCTIONS

    /**
     * Appends the given $object to the collection
     *
     * This function override the parent append to do type checking
     *
     */
    public function append($object)
    {
        throw new RuntimeException("Appending to PropertySet is not supported");
    }

    /**
     * Sets the given offset to the given $object
     *
     * This function override the parent offsetSet to do type checking
     *
     */
    public function offsetSet($offset, $object)
    {
        $this->checkType($object);
        if (empty($offset)) {
            throw new RuntimeException("Unnamed properties are not supported");
        }
        return parent::offsetSet($offset, $object);
    }

    /**
     * Checks that $object is an instance of Morph_Property_Generic
     *
     * Throws a RuntimeException if not
     *
     * @param $object
     */
    private function checkType($object){
        if(!($object instanceof Morph_Property_Generic)){
            throw new InvalidArgumentException('object of type' . get_class($object) . ' does not extend Morph_Property_Generic');
        }
    }

}
