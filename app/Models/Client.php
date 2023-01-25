<?php

namespace App\Models;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model {
    use HasFactory;
    protected $guarded = [];

    public function plan() {
        return $this->hasOne(Plan::class);
    }
}
