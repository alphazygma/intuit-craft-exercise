<?php
namespace Intuit\Storage\Database;

interface Database
{
    public function transaction($closure);
}
