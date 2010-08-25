<?php
/**
 * @package Morph
 * @author Jonathan Moss <xirisr@gmail.com>
 * @copyright Jonathan Moss 2009
 */

/**
 * A base class for creating model objects for storing in MongoDB.
 *
 * @package Morph
 */
class Morph_Object
{

    const STATE_NEW   = 'New';
    const STATE_CLEAN = 'Clean';
    const STATE_DIRTY = 'Dirty';

    /**
     * @var Morph_Storage
     */
    protected $Storage;

    /**
     * The name of the collection this object is stored within
     * @var string
     */
    protected $Collection;

    /**
     * The unique id for this object
     * @var string
     */
    protected $Id;

    /**
     * The current state of this object
     *
     * one of Morph_Object::STATE_*
     * @var string
     */
    protected $State;

    /**
     * The data associated with this object
     * @var Morph_PropertySet
     */
    protected $propertySet;

    /**
     * The collections of validators for propertys
     * @var array
     */
    protected $Validators;

    /**
     * @param string $id If supplied this will be the id used to reference this object
     * @return Morph_Object
     */
    public function __construct($id = null)
    {
        $this->State = self::STATE_NEW;
        $this->Id = $id;
        $this->propertySet = new Morph_PropertySet();
        $this->Validators = array();
    }

    // *********************** //
    // GETTER/SETTER FUNCTIONS //
    // *********************** //

    /**
     * Returns the name of the collection this object should be stored in
     *
     * @param string $collection
     * @return string
     */
    public function collection($collection = null)
    {
        if (!is_null($collection)) {
            $this->Collection = $collection;
        }elseif (is_null($this->Collection)) {
            //defaults collection name to class name
            $this->Collection = Morph_Utils::collectionName($this);
        }
        return $this->Collection;
    }

    /**
     * Returns the Id of this object
     * @return string
     */
    public function id()
    {
        return $this->Id;
    }

    /**
     * Returns the state of this object
     *
     * Will be one of Morph_Object::STATE_*
     *
     * @return string
     */
    public function state()
    {
        return $this->State;
    }

    /**
     * Sets the storage object for this object
     * @param Morph_Storage $storage
     * @return void
     */
    public function __setStorage(Morph_Storage $storage)
    {
        $this->Storage = $storage;
        $this->propertySet->setStorage($storage);
    }

    /**
     * Adds a new property to this object
     *
     * @param Morph_Property_Generic $property
     * @return Morph_Object
     */
    protected function addProperty(Morph_Property_Generic $property)
    {
        $this->propertySet[$property->getName()] = $property;
        return $this;
    }

    /**
     * Sets the property data for this object
     *
     * @param $data
     * @param $state
     * @return Morph_Object
     */
    public function __setData(array $data, $state = self::STATE_DIRTY)
    {
        if (array_key_exists('_id', $data)) {
            $this->Id = $data['_id'];
            unset($data['_id']);
        }
        if (array_key_exists('_ns', $data)) {
            unset($data['_ns']);
        }
        foreach ($data as $propertyName => $value) {
            $this->propertySet->__setRawPropertyValue($propertyName, $value);
        }
        $this->State = $state;
        return $this;
    }

    /**
     * Gets the property data for this object
     *
     * @return array
     */
    public function __getData()
    {
        $data = array();
        if (!is_null($this->Id)) {
            $data['_id'] = $this->Id;
        }
        $data['_ns'] = get_class($this);
        foreach($this->propertySet as $property) {
            $data[$property->getName()] = $property->__getRawValue();
            $data = array_filter($data);
        }
        return $data;
    }

    // ********************** //
    // MAGIC ACCESS FUNCTIONS //
    // ********************** //

    /**
     *
     * @param $propertyName
     * @return mixed
     */
    public function __get($propertyName)
    {
        $value = null;
        if (array_key_exists($propertyName, $this->propertySet)) {
            $value = $this->propertySet[$propertyName]->getValue();
        }else{
            trigger_error("The property $propertyName was not found in object of class " . get_class($this), E_USER_WARNING);
        }
        return $value;
    }

    /**
     *
     * @param $propertyName
     * @param $propertyValue
     * @return Morph_Object
     */
    public function __set($propertyName, $propertyValue)
    {
        if (array_key_exists($propertyName, $this->propertySet)) {
            $this->propertySet[$propertyName]->setValue($propertyValue);
            if ($this->State == self::STATE_CLEAN) {
                $this->State = self::STATE_DIRTY;
            }
        }else{
            /*
             * @todo Should I just create an instance of Morph_Property_Generic?
             * MongoDB is schemaless after all. I could trigger an error as well
             * giving devs a chance to see that they are doing something wrong.
             */
            trigger_error("The property $propertyName was not found in object of class " . get_class($this), E_USER_WARNING);
        }
        return $this;
    }

    // ***************** //
    // UTILITY FUNCTIONS //
    // ***************** //

    /**
     * Converts this object to a string
     *
     * Useful for debugging output but not much else
     *
     * @return string
     */
    public function __toString()
    {
        $string = "";
        $string .= "Id: " . $this->id() . "\n";
        $string .= "State: " . $this->state() . "\n";
        foreach ($this->propertySet as $property) {
            $string .= (string)$property . "\n";
        }
        return $string;
    }

    /**
     * Returns the content of this object as an array suitable for merging with a template
     *
     * @param $depth The maximum depth to traverse the tree
     * @return array
     */
    public function __toArray($depth = 1)
    {
        $content = array();
        --$depth;
        foreach ($this->propertySet as $property) {
            $value = $property->getValue();

            switch (true) {
                case ($value instanceof Morph_Object):
                    if ($depth > 0) {
                        $content[$value->getName()] = $value->__toArray($depth);
                    }
                    break;
                case ($value instanceof Morph_Collection):
                    if ($depth > 0) {
                        $valueContents = array();
                        foreach ($value as $object) {
                            $valueContents[] = $object->__toArray($depth);
                        }
                        $content[$value->getName()] = $valueContents;
                    }
                    break;
                default:
                    $content[$property->getName()] = $value;
                    break;
            }

        }

        return $content;
    }
}
