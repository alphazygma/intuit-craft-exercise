<?php
namespace Intuit\Storage\Database;

class EloquentDatabase implements Database
{
    public function transaction($closure)
    {
        return \DB::transaction($closure);
    }

}
