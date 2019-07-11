<?php
namespace Modules\Address\Services;

trait DistrictInforUpdate

{
	public function families()
	{
		$families = [];
		foreach ($this->towns as $town) {
			foreach ($town->locations as $location) {
				foreach ($location->families as $family) {
					$families[] = $family;
				}
			}
		}
		return $families;
	}

	public function users()
	{
		$users = [];
		foreach ($this->towns as $town) {
			foreach ($town->locations as $location) {
                foreach ($location->families as $family) {
                	foreach ($family->profiles as $profile) {
                		$users[] = $profile->user;
                		if($profile->husband){
                			foreach ($profile->husband->marriages as $marriage) {
                				if(is_null($marriage->wife->profile->family_id)){
                					$users[] = $marriage->wife->profile->user;
                				}
                			}
                		}
                	}
				}
			}
		}
		return $users;
	}

	public function marriages()
	{
		$marriages = [];
		foreach ($this->towns as $town) {
			foreach ($town->locations as $location) {
                foreach ($location->families as $family) {
                	foreach ($family->familyAdmin->profile->husband->marriages as $marriage) {
                		$marriages[] = $marriage;
                	}
				}
			}
		}
		return $marriages;
	}

	public function births()
	{
		$births = [];
		foreach ($this->towns as $town) {
			foreach ($town->areas as $area) {
				if($area->house){
					foreach ($area->house->address->profile->husband->father->births as $birth) {
						$births[] = $birth;
					}
				}
			}
		}
		return $births;
	}

	public function deaths()
	{
		$deaths = [];
		foreach ($this->towns as $town) {
			foreach ($town->areas as $area) {
				if($area->house){
					$births[] = $area->house->address->profile->death;
				}
			}
		}
		return $deaths;
	}

	public function divorces()
	{
		$divorces = [];
		foreach ($this->towns as $town) {
			foreach ($town->areas as $area) {
				if($area->house){
					foreach ($area->house->address->profile->husband->marriages as $marriage) {
						$divorces[] = $marriage->divorce;
					}
				}
			}
		}
		return $divorces;
	}

	public function returnDivorces()
	{
		$return_wife = [];
		foreach ($this->towns as $town) {
			foreach ($town->areas as $area) {
				if($area->house){
					foreach ($area->house->address->profile->husband->marriages as $marriage) {
						foreach ($marriage->divorce->details as $detail) {
							$return_wife[] = $detail->return;
						}
					}
				}
			}
		}
		return $return_wife;
	}
}