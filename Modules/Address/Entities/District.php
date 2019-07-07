<?php

namespace Modules\Address\Entities;

use Modules\Core\Entities\BaseModel;

use Modules\Address\Services\DistrictInforUpdate;

class District extends BaseModel
{
	use DistrictInforUpdate;
	
	public function towns()
	{
		return $this->hasMany(Town::class);
	}

	public function lga()
	{
		return $this->belongsTo(Lga::class);
	}

	public function government()
    {
        return $this->hasOne('Modules\Government\Entities\Government');
    }

    public function admin()
    {
        return $this->hasOne('Modules\Admin\Entities\Admin');
    }
    
}
