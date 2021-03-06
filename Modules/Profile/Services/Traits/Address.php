<?php

namespace Modules\Profile\Services\Traits;

trait Address

{
	public function address()
	{
		
		if ($this->leave != null){
			$address = $this->leave->address;
			$user_address = [
	            'country' => $address->house->area->town->district->lga->state->country->name,
	            'state' => $address->house->area->town->district->lga->state->name,
	            'lga' => $address->house->area->town->district->lga->name,
	            'district' => $address->house->area->town->district->name,
	            'town' => $address->house->area->town->name,
	            'area' => $address->house->area->name,
	            'house_no' => $address->house->house_no,
	            'house_description' => $address->house->house_desc,
	        ];
		}else{
			$address = $this->family->location;
			$user_address = [
	            'country' => $address->area->town->district->lga->state->country->name,
	            'state' => $address->area->town->district->lga->state->name,
	            'lga' => $address->area->town->district->lga->name,
	            'district' => $address->area->town->district->name,
	            'town' => $address->area->town->name,
	            'area' => $address->area->name,
	            'house_no' => '',
	            'house_description' => '',
	        ];
		}
		return $user_address;
	}

	public function businessAddress()
	{
		
		if ($this->work != null){
			$address = $this->work->address;
			$busibess_address = [
	            'country' => $address->office->company->town->lga->state->country->name,
	            'state' => $address->office->company->town->district->lga->state->name,
	            'lga' => $address->office->company->town->district->lga->name,
	            'company' => $address->office->company->name,
	            'town' => $address->office->company->town->name,
	            'office' => $address->office->name,
	            'position' => $address->position,
	            
	        ];
		}else{
			
			$busibess_address = [
	            'country' => '',
	            'state' => '',
	            'lga' => '',
	            'company' => '',
	            'town' => '',
	            'office' => '',
	            'position' => '',
	            
	        ];
		}
		return $busibess_address;
	}
}