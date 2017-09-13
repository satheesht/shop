<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    /*
    | This functions returns categories available which is retrieved by url given
    */
    public function getCategories(){
        $client = new Client();
        $res = $client->request('GET', 'http://www.bamilo.com/mobapi/v2.3/catalog/categories');
       if($res->getStatusCode()===200){
        return response($res->getBody())
        ->header('Content-Type', $res->getHeader('content-type'));
       }else{
           return response('{statusCode:'.$res->getStatusCode().'}');
       }
        
    }
}
