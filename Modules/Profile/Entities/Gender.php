<?php

namespace Modules\Profile\Entities;

use Modules\Core\Entities\BaseModel;

class Gender extends BaseModel
{

    public function profile()
    {
    	return $this->hasMany(Profile::class);
    }
}
