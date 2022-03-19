<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PriceListRole extends Model
{
    use HasFactory;

    protected $table = 'price_list_role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'up_down', 'percentage_cash', 'value', 'category_id', 'price_list_id', 'admin_id', 'created_at', 'updated_at'
    ];

    public function  scopeSelection($query){

        return $query -> select(
            'id', 'up_down', 'percentage_cash', 'value', 'category_id', 'price_list_id', 'admin_id', 'created_at', 'updated_at'
        );
    }

}
