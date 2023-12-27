<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantExpense extends Model
{
    use HasFactory;

    public function expdetail(){
        return $this->hasMany('App\Models\RestaurantExpDetail');
    }
}
