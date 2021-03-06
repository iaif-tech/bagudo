<?php

namespace Modules\Education\Http\Controllers\School;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Profile\Entities\Profile;
use Modules\Education\Entities\Admitted;
use Modules\Government\Events\Education\School\NewAdmissionEvent;
use Modules\Core\Http\Controllers\Education\EducationBaseController;

class AdmissionController extends EducationBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $admissions = [];
        foreach(schoolAdmin()->school->admitteds as $admission){
            if($admission->year == request()->route('year')){
                $admissions[] = $admission;
            }
        }
        return view('education::Education.School.Admission.index',['admissions'=>$admissions,'years'=>$this->getValidYears()]);
    }

    public function listIndex()
    {
        return view('education::Education.School.Admission.List.index',['years'=>$this->getValidYears()]);
    }
    
    public function admissionSearch(Request $request)
    {
        $request->validate(['year'=>'required']);
        return redirect()->route('education.school.admission.index',[$request->year]);
    }


    public function getValidYears()
    {
        $years = [];
        for ($i = date('Y') ; $i >= date('Y') - 20 ; $i-- ) { 
            $years[] = $i;
        }
        return $years;
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('education::Education.School.Admission.create',['years'=>$this->getValidYears()]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'year'=>'required',
            'admission_no'=>'required'
        ]);
        $errors = [];
        //is this profile exist
        $profile = Profile::where('FID',$request->fid)->first();
        if(!$profile){
            $errors[] = 'Invali Student Profile ID';
        }
        if($profile && !schoolAdmin()->school->validateThisProfileAdmission($profile->id)){
            $errors[] = 'Sorry we already admitted this student in this school';
        }
        if($this->hasAsignedNumber($request->admission_no, $request->year)){
            $errors[] = $request->admission_no.' was already used by another student at '.$request->year;
        }
        if(empty($errors)){
            $profile->admitteds()->create([
                'school_id'=>schoolAdmin()->school->id,
                'admission_no' => $request->admission_no,
                'year' => $request->year,
                'teacher_id' => schoolAdmin()->id
            ]);
            event(new NewAdmissionEvent($profile));
            session()->flash('message','Congratulation the admission is created success fully');
        }else{
            session()->flash('error',$errors);
            return back();
        }
        return redirect()->route('education.school.admission.index',[$request->year]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function hasAsignedNumber($number,$year)
    {
        $flag = false;
        foreach (schoolAdmin()->school->admitteds->where('admission_no',$number)->where('year',$year) as $admission) {
            $flag = true;
        }
        return $flag;
    }
    public function update(Request $request, $year, $admission_id)
    {
        $request->validate([
            'fid'=>'required',
            'admission_no'=>'required',
            'year'=>'required'
        ]);
        $errors = [];
        //is this profile exist
        $profile = Profile::find($request->profile_id);
        if($this->hasAsignedNumber($request->admission_no, $request->year)){
            $errors[] = $request->admission_no.' was already used by another student at '.$request->year;
        }
        if(empty($errors)){
            Admitted::find($admission_id)->update([
                'school_id'=>schoolAdmin()->school->id,
                'admission_no' => $request->admission_no,
                'year' => $request->year,
                'teacher_id' => schoolAdmin()->id
            ]);
            session()->flash('message','Congratulation the admission is updated success fully');
        }else{
            session()->flash('error',$errors);
        }
        return redirect()->route('education.school.admission.index',[$request->year]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete($year, $admission_id)
    {
        Admitted::find($admission_id)->delete();
        session()->flash('message','Congratulation the admission is deleted success fully');
        return back();
    }
}
