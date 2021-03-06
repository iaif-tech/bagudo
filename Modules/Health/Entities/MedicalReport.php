<?php

namespace Modules\Health\Entities;

use Modules\Core\Entities\BaseModel;

class MedicalReport extends BaseModel
{
    public function hospitalAdmission()
    {
    	return $this->belongsTo(HospitalAdmission::class)
    }
}
