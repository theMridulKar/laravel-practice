<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    *
    * Works good in local server
    *
    * Helper function
    *
    * @return image_name
    *
    */

    public function upload_image_file($image, $image_path, $prefix=""){
        $image_name = $prefix.time().random_int(1000,9999).".". $image->getClientOriginalExtension();
        $image->move($image_path, $image_name);
        return $image_name;
    }

    /** 
    *works good in vpn server
    */

    // public function upload_image_file($image, $image_path, $prefix=""){
    //     $imageName = $prefix.time().random_int(1000,9999).".". $image->getClientOriginalExtension();
    //     $image->move(public_path()."/".$image_path, $imageName);
    //     return $imageName;
    // }
}
