<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'status','amount'];

    public function getStatusAttribute($value)
    {
        if($value==1){
            $getVal='Completed';
        }
        if($value==2){
            $getVal='Pending';
        }
        if($value==3){
            $getVal='Declined';
        }
        return $getVal;
    }

    public function getPaymentStatusAttribute($value)
    {
        if($value==1){
            $getVal='Paid';
        }
        if($value==2){
            $getVal='Unpaid';
        }

        return $getVal;
    }
}
