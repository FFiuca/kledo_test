<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApproverController extends Controller
{

    public function create(Request $request){
        $data = $request->only([
            'name'
        ]);
        $form = null;

        try{

        }catch(ValidationException $e){

        }catch(Exception $e){

        }
    }
}
