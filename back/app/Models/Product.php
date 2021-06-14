<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $dates = ['created'];
    protected $table = 'Products';

    const CREATED_AT = 'created';
    const UPDATED_AT = 'created';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','type','description','filename','height','width','price','rating'
    ];
    public function getCreatedAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }



}
