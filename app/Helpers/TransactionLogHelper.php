<?php
namespace App\Helpers;

use App\Models\TransactionLogs;
use Illuminate\Support\Facades\Auth;

function tranLog($data = []){
    
    if(!isset($data['type'])){
        return false;
    }
    if(!isset($data['title'])){
        return false;
    }
    if(!isset($data['description'])){
        return false;
    }

    $user = Auth::user();
    $userId = null;

    if(!empty($user) && isset($user['id'])){
        $userId = $user['id'];
    }
    $log = TransactionLogs::create([
        'type'=>$data['type'],
        'title'=>$data['title'],
        'description'=>$data['description'],
        'user_id'=>$userId,
        'booking_id'=>isset($data['booking_id'])?$data['booking_id']:NULL,
    ]);

}