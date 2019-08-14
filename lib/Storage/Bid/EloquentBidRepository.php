<?php
namespace Intuit\Storage\Bid;

use App\Bid;

class EloquentBidRepository implements BidRepository
{
    public function all() {
        return Bid::all();
    }

    public function find($id) {
        return Bid::find($id);
    }

    public function create($input) {
        return Bid::create($input);
    }

    public function save($entity) {
        return $entity->save();
    }
}
