<?php

namespace Modules\Government\Events\Health;

use Illuminate\Queue\SerializesModels;

class NewStateCitizenHospitalDeathEvent
{
    use SerializesModels;

    private $location;
    private $month;
    private $year;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DischargeAdmission $disacharge)
    {
        $this->year = Year::firstOrCreate(['year'=>date('Y')]);
        $this->month = $this->getCurrentMonth();
        $this->location = $disccharge->hospitalAdmission->diagnose->profile->thisProfileFamily->location;
        $this->countInTheAdmission();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function getCurrentMonth()
    {
        foreach (Month::where('month',date('F'))->get() as $month) {
            return $month;
        }
    }
    
    public function updateAreaDischarge()
    {
        //get the last month of the year
        $area_discharge = $location->area->areaHospitalReportCollations->last();
        //if this month discharge exit update it from the discharge of the last month
        if($area_discharge){
            if($area_discharge->month_id == $this->month->id){
                $area_discharge->update([
                    'death'=>$area_discharge->discharge += 1,
                    'monthly_death'=>$area_discharge->monthly_discharge += 1,
                ]);
            }else{
                $location->area->areaHospitalReportCollations()->create([
                'year_id'=>$this->year->id,
                'month_id'=>$this->month->id,
                'death'=> $area_discharge->discharge + 1,
                'monthly_death'=> 1
            ]);
            }
        }else{
            $location->area->areaHospitalReportCollations()->create([
                'year_id'=>$this->year->id,
                'month_id'=>$this->month->id,
                'death'=>1,
                'monthly_death'=>1
            ]);
        }
        
    }

    public function updateTownDischarge()
    {
        //get the last month of the year
        $town_discharge = $location->area->town->townHospitalReportCollations->last();
        
        //if this month discharge exit update it from the discharge of the last month
        if($town_discharge){
            if($town_discharge->month_id == $this->month->id){
                $town_discharge->update([
                    'death'=>$town_discharge->discharge += 1,
                    'monthly_death'=>$town_discharge->monthly_discharge += 1,
                ]);
            }else{
                $location->area->town->townHospitalReportCollations()->create([
                    'year_id'=>$this->year->id,
                    'month_id'=>$this->month->id,
                    'death'=> $town_discharge->discharge + 1,
                    'monthly_death'=> 1
                ]);
            }
        }else{
            $location->area->town->townHospitalReportCollations()->create([
                'year_id'=>$this->year->id,
                'month_id'=>$this->month->id,
                'death'=>1,
                'monthly_death'=>1
            ]);
        }
        
    }
    
    public function updateDistrictDischarge()
    {
        $district_discharge = $location->area->town->district->districtHospitalReportCollations->last();

        if($district_discharge){
            if($district_discharge->month_id == $this->month->id){
                $district_discharge->update([
                    'death'=>$district_discharge->discharge += 1,
                    'monthly_death'=>$district_discharge->monthly_discharge += 1,
                ]);
            }else{
                $location->area->town->district->districtHospitalReportCollations()->create([
                    'year_id'=>$this->year->id,
                    'month_id'=>$this->month->id,
                    'death'=> $district_discharge->discharge + 1,
                    'monthly_death'=> 1
                ]);
            }
        }else{
            $location->area->town->district->districtHospitalReportCollations()->create(
                [
                    'year_id'=>$this->year->id,
                    'month_id'=>$this->month->id,
                    'death'=>1,
                    'monthly_death'=>1
                ]
            );
        }
    }

    public function updateLgaDischarge()
    {
        $lga_discharge = $location->area->town->district->lga->lgaHospitalReportCollations->last();
        if($lga_discharge){
            if($lga_discharge->month_id == $this->month->id){
                $lga_discharge->update([
                    'death'=>$lga_discharge->discharge += 1,
                    'monthly_death'=>$lga_discharge->monthly_discharge += 1,
                ]);
            }else{
                $location->area->town->district->lga->lgaHospitalReportCollations()->create([
                    'year_id'=>$this->year->id,
                    'month_id'=>$this->month->id,
                    'death'=> $lga_discharge->discharge + 1,
                    'monthly_death'=> 1
                ]);
            }
        }else{
            $location->area->town->district->lga->lgaHospitalReportCollations()->create([
                    'year_id'=>$this->year->id,
                    'month_id'=>$this->month->id,
                    'death'=>1,
                    'monthly_death'=>1
                ]
            );
        }
    }

    public function countInTheDischarge()
    {
        $this->updateAreaDischarge();
        $this->updateTownDischarge();
        $this->updateDistrictDischarge();
        $this->updateLgaDischarge();
    }
}
