<?php
namespace Intuit\Storage\Bid;


interface BidRepository
{
    public function all();

    public function find($id);

    public function create($input);

    public function save($entity);

}
