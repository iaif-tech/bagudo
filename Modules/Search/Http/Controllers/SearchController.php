<?php

namespace Modules\Search\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Controllers\BaseController;
use Modules\Search\Services\Traits\SearchUser;
use App\User;

class SearchController extends BaseController
{
    use SearchUser;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('search::index');
    }

    public function identity()
    {
        return view('search::identity');
    }

    public function relative()
    {
        return view('search::index');
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('search::create');
    }
 
    public function getGenerations(Request $request)
    {
        session(['user_id'=>$request->id]); 
        session()->flash('generation',$request->id);
        return redirect()->route('search.identity.index');
    }
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        if(isset($request->generation)){
            $user = User::find(session('user_id'));
            session()->flash('gen_result',$user->getSearchGenerationResult($request->gen_no));
            return back();
            
        }elseif(isset($request->search_identity)){
            $users_found = $this->searchUsers($request->fname,$request->lname);
            session()->flash('users_result',$users_found);
            session()->flash('message', count($users_found)." Alternative Users matches result for $request->fname $request->lname");
            return redirect()->route('search.identity.index');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('search::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('search::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
