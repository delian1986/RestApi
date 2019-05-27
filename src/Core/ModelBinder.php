<?php


namespace Src\Core;


use Src\Models\CategoryModel;

class ModelBinder implements ModelBinderInterface
{

    public function bind(array $from, $className)
    {
        $object = new $className();

        foreach ($from as $key => $value) {
            $tokens=explode('_',$key);
            $setter='set'.ucfirst($tokens[0]);

            for ($i=1;$i<count($tokens);$i++){
                $setter.=ucfirst($tokens[$i]);
            }

            if (method_exists($object,$setter)){
                if ($setter==='setCategory' && is_int($value)){
                    $object->$setter(new CategoryModel());
                    $object->getCategory()->setId($value);
                    continue;
                }
                $object->$setter($value);
            }
        }

        return $object;
    }
}