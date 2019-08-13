<?php
namespace Modules\Education\Services\Traits;

use Modules\Address\Entities\State;
use Modules\Profile\Entities\Gender;
use Modules\Education\Entities\School;
use Modules\Education\Entities\SchoolType;
use Modules\Education\Entities\SchoolCategory;

trait TeacherAndCategoriesRange
{
    public function getSchools()
    {
        $schools = [];

        foreach ($this->availableSchools() as $school) {
            if($school->schoolType->name == request()->route('school_category')){
                $schools[] = $school;
            }
        }
        return $schools;;
    }

	public function nurseryIndex()
    {
        
        return view('education::Admin.Teacher.index',[
                    'schools'=>$this->getSchools(),
                    'school_types'=>SchoolType::all(),
                    'school_categories'=>SchoolCategory::all(),
                    'districts'=>$this->availableDistricts(),
                    'states'=>State::all(),
                    'genders'=>Gender::all()
                ]);
    }

    public function primaryIndex()
    {
    
        return view('education::Admin.Teacher.index',[
                    'schools'=>$this->getSchools(),
                    'school_types'=>SchoolType::all(),
                    'school_categories'=>SchoolCategory::all(),
                    'districts'=>$this->availableDistricts(),
                    'states'=>State::all(),
                    'genders'=>Gender::all() 
                ]);
    }

    public function secondaryIndex()
    {
        
        return view('education::Admin.Teacher.index',[
                    'schools'=>$this->getSchools(),
                    'school_types'=>SchoolType::all(),
                    'school_categories'=>SchoolCategory::all(),
                    'districts'=>$this->availableDistricts(),
                    'states'=>State::all(),
                    'genders'=>Gender::all()
                    
                ]);
    }
}