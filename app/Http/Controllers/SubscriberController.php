<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Yoeunes\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function store(Request $request){
    //    return $request->all();
    $this->validate($request,[
        'email' => 'required|email|unique:subscribers'
    ]);

    $subscriber = new Subscriber();
    $subscriber->email = $request->email;
    $subscriber->save();
    Toastr::success('You Successfully added to our subscriber list :)','Success');
    return redirect()->back();
    }
}
