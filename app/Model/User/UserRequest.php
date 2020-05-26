<?php
namespace App\Model\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends FormRequest {

	public function rules(Request $request)
	{
		$id = $request->id ? ',' . $request->id : '';
		
		if($request->chnpassword=="" && $id){
			$arrRule = [
						'name' 	=> 'required|max:255',
						'email' => 'required|email|max:255|unique:users,email'.$id,
						'role' => 'required'					
					];
			
		}else{
			$arrRule = [
						'name' 	=> 'required|max:255',
						'email' => 'required|email|max:255|unique:users,email'.$id,
						'role' => 'required',
						'password' => 'required|confirmed|min:6',	
					];
		}
		if($request->id && \Auth::user()->id == $request->id){
			unset($arrRule['role']);
		}
		return $arrRule;
		
	}

    public function authorize()
    {
        return true;
    }

}
