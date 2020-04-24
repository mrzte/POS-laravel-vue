<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Product extends Model
{
    protected $guarded = [];
    protected $fillable = ['code','nama','description','category_id','photo','price','stock','user_id'];
}
