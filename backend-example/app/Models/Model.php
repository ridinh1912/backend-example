<?php

namespace App\Models;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function getResource()
    {
        $resourceClass = get_class($this).'Resource';
        $resourceClass = str_replace('Models', 'Transformers', $resourceClass);

        return new $resourceClass($this);
    }
}
