<?php

namespace Modules\Birth\Services\Register\Validation\ValidInit;

use Modules\Marriage\Entities\Status;

use App\User;

trait VerifyMother

{
	
    public function nameAuth()
    {
    	$this->status = Status::find($this->data['mother_status']);
        $user_id = $this->motherUserIds();
        
        $flag = false;
        foreach($user_id as $id){
			if($this->status->wife[0]->profile->user->id == $id){
			    $flag = true;
			}
        }
        if($flag == false){
        	$this->error[] = "Mother's name authentication fails invalid combination of mother name and surname or mother status";
        }
    	
    }

    public function motherUserIds()
    {
    	$id = [];
        foreach(User::where(['first_name'=>$this->data['mother_first_name'],
    		'last_name'=>$this->data['mother_last_name']])->get() as $user){
        	$id[] = $user->id;
        }
        return $id;
    }
}