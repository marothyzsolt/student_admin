<?php


namespace App\Entity;


use Symfony\Component\Serializer\Serializer;

abstract class BaseEntity
{
    public function getProperties() {
        $properties = array();
        try {
            $rc = new \ReflectionClass($this);
            do {
                $rp = array();
                /* @var $p \ReflectionProperty */
                foreach ($rc->getProperties() as $p) {
                    $p->setAccessible(true);
                    $rp[$p->getName()] = $p->getValue($this);
                }
                $properties = array_merge($rp, $properties);
            } while ($rc = $rc->getParentClass());
        } catch (\ReflectionException $e) { }
        return $properties;
    }

    public function toArray($recursive = true)
    {
        $entityAsArray = $this->getProperties();

        if ($recursive) {
            foreach ($entityAsArray as &$var) {
                if ((is_object($var)) && (method_exists($var, 'toArray'))) {
                    $var = $var->toArray($recursive);
                }
                if(is_array($var)) {
                    foreach ($var as $index => &$item) {
                        if ((is_object($item)) && (method_exists($item, 'toArray'))) {
                            $item = $item->toArray(false);
                        }
                    }
                }
            }
        }

        return $entityAsArray;
    }
}