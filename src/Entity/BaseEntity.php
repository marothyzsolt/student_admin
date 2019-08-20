<?php


namespace App\Entity;


use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Serializer\Serializer;

abstract class BaseEntity
{
    protected $__extends = [];
    protected $__extendsRecursive = [];

    public function getProperties() {
        $properties = array();
        try {
            $rc = new \ReflectionClass($this);
            do {
                $rp = array();
                /* @var $p \ReflectionProperty */
                foreach ($rc->getProperties() as $p) {
                    if (strpos($p->getName(), '__') !== 0) {
                        $p->setAccessible(true);
                        $rp[$p->getName()] = $p->getValue($this);
                    }
                }
                $properties = array_merge($rp, $properties);
            } while ($rc = $rc->getParentClass());
        } catch (\ReflectionException $e) { }
        return $properties;
    }

    public function toArray($recursive = true)
    {
        $entityAsArray = $this->getProperties();
        foreach ($entityAsArray as $index => $item) {
            if(isset($this->__extends[$index])) {
                if(isset($this->__extends[$index]['method']))
                {
                    $methodName = '_'.$this->__extends[$index]['method'];
                } else {
                    if(is_array($this->__extends[$index])) {
                        throw new \InvalidArgumentException('__extends protected class variable\'s values must contains "method" array key, or must be a string: '. json_encode($this->__extends));
                    }
                    $methodName = '_'.$this->__extends[$index];
                }
                if(method_exists($this, $methodName)) {
                    $returnValue = $this->$methodName($item);
                    if(isset($this->__extends[$index]['alias']))
                    {
                        $aliasName = $this->__extends[$index]['alias'];
                    } else {
                        if(is_array($this->__extends[$index])) {
                            throw new \InvalidArgumentException('__extends protected class variable\'s values must contains "alias" array key, or must be a string: '. json_encode($this->__extends));
                        }
                        $aliasName = $this->__extends[$index];
                    }

                    $entityAsArray[$aliasName] = $returnValue;
                }
            }
        }

        if ($recursive) {
            foreach ($entityAsArray as $key => &$var) {
                if ((is_object($var)) && (method_exists($var, 'toArray'))) {
                    $var = $var->toArray($recursive);
                }
                if(is_array($var)) {
                    foreach ($var as $index => &$item) {
                        if ((is_object($item)) && (method_exists($item, 'toArray'))) {
                            $item = $item->toArray(in_array($key, $this->__extendsRecursive));
                        }
                    }
                }
            }
        }

        return $entityAsArray;
    }

    public function _count($obj)
    {
        return $obj->count();
    }
}