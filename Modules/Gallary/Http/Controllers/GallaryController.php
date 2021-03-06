<?php

namespace Modules\Gallary\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Controllers\BaseController;
use Modules\Gallary\Entities\Album;
use Modules\Gallary\Entities\Photo;
use Modules\Gallary\Entities\Video;
use Modules\Gallary\Entities\Audio;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Services\Traits\UploadFile;
use App\User;
class GallaryController extends BaseController
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function privateIndex()
    {
        return view('gallary::private.index',['profile'=>$this->profile()]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function nuclearIndex()
    {
        return view('gallary::nuclear.index',['profile'=>$this->profile()]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function extendedIndex()
    {
        return view('gallary::extended.index',['profile'=>$this->profile()]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function createAlbum(Request $request, $family, Album $album)

    { 
        $data = $request->all();
        $request['name'] = $request->name.'_'.time();
        $new_album = $album->create($request->all());
        switch ($data['album_type_id']) {
            case '1':
                $new_album->profileAlbum()->create(['profile_id'=>$this->profile()->id]);
                break;
            case '2':
                $new_album->familyAlbum()->create(['family_id'=>$this->profile()->family->id]);
                break;
            default:
                $new_album->familyAlbum()->create(['family_id'=>$this->profile()->family->root()->id]);
                break;
        }
        
        session()->flash('message','Album created successfully');
        return back();
    }

    /**
     * store audio vedio or photo to their respective album.
     * @return Response
     */
    public function upload(Request $request, $family)
    {
        $album = Album::find($request->album_id);
        $flag = null;
        switch ($album->albumContentType->name) {
            case 'Audio':
                $flag = 'Audio';
                // $request->validate([
                //     'file' => 'required|mimes:wav,mpeg,ogg,mp3,opus'
                // ]);
                break;
            case 'Vedio':
            $flag = 'Video';
                $request->validate([
                    'file' => 'required|mimes:avi,mpeg,quicktime,mp4'
                ]);
                break;
            default:
            $flag = 'Photo';
                $request->validate([
                    'file' => 'required|image|mimes:jpeg,bmp,png,jpg,mp3,opus',
                ]);
                break;
        }
        $path = 'Nfamily/Gallary/'.$album->albumContentType->name.'/'.$album->name;
        $filename = $this->storeFile($request->file('file'),$path);
        
        switch ($flag) {
            case 'Audio':
                $album->audios()->create(['audio'=>$filename,'title'=>$request->title,'description'=>$request->description,'published'=>$request->published]);
                break;
            case 'Video':
                $album->videos()->create(['video'=>$filename,'title'=>$request->title,'description'=>$request->description,'published'=>$request->published]);
                break;
            
            case 'Photo':
                $album->photos()->create(['photo'=>$filename,'title'=>$request->title,'description'=>$request->description,'published'=>$request->published]);
                break;
            default:
                # code...
                break;
        }
        
        session()->flash('message',$flag.' was added successfully to '.$album->getName().' Album');
        return back();
    } 

    public function delete(Request $request, $family)
    {
        $album = Album::find($request->album_id);
        if($album->profileAlbum == null){
            $album->familyAlbum()->delete();
        }else{
            $album->profileAlbum()->delete();
        }
        $path = 'nfamilyplus/Gallary/'.$album->albumContentType->name.'/'.$album->name.'/';
        switch ($album->albumContentType->name) {
            case 'Audio':
                foreach($album->audios as $audio){
                    Storage::disk($this->fileSystem())->delete(storage_url($path.$audio->audio));
                   $audio->delete();
                }
               break;
            case 'Video':
                foreach($album->videos as $video){
                     Storage::disk($this->fileSystem())->delete(storage_url($path.$video->video));
                    $video->delete();
                }
               break;
            default:
                foreach($album->photos as $photo){
                    Storage::disk($this->fileSystem())->delete(storage_url($path.$photo->photo));
                   $photo->delete();
                }
               break;
        }
        Storage::disk($this->fileSystem())->deleteDirectory(storage_url($path));
       $album->delete();
       session()->flash('message','Album was successfully deleted');
       return back();
    }

    public function grantAccess(Request $request, $family)
    {
        $error = [];
        $album = Album::find($request->album_id);
        $request->validate([
            'accessor' => 'required',
            'email' => 'required|email',
        ]);
        $accessor = null;
        foreach (User::where('email',$request->email)->get() as $user) {
            $accessor = $user;
        }
        if($accessor == null){
            $error[]= $request->email.' does not exist in our record';
        }
        if($accessor != null && $accessor->profile == null){
            $error[]= 'The accessor profile does not exist in our record';
        }
        if(empty($error)){
            if($accessor->profile->id == $this->profile()->id){
                $error[]= $request->email.' is your email you cannot grant access to ur self';
            }
        }
        
        if(empty($error)){
            if($request->accessor == 'user'){
                $album->accessAlbums()->create(['profile_id'=>$accessor->profile->id]);
            }else{
                $album->accessAlbums()->create(['family_id'=>$accessor->profile->family_id]);
            }
            session()->flash('message','Album was successfully granted access to '.$accessor->first_name.' '.$accessor->last_name);
        }else{
            session()->flash('error',$error);
        }
        
        return back();
    }
    public function published(Request $request, $family)
    {

        $album = Album::find($request->album_id);
        if($album->published == 'on'){
            session()->flash('error',[$album->getName().' '.$album->albumContentType->name.' Album was already published']);
        }else{
            $album->published = 'on';
            $album->save();
            session()->flash('message',$album->getName().' '.$album->albumContentType->name.' Album was published successfully');
        }
        
        return back();
    }

    public function update(Request $request, $family)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);
        switch ($request->type) {
            case 'Photo':
                $photo = Photo::find($request->id);
                $photo->title = $request->title;
                $photo->description = $request->description;
                $photo->published = $request->published;
                $photo->save();
                break;

            case 'Video':
                $video = Video::find($request->id);
                $video->title = $request->title;
                $video->description = $request->description;
                $video->published = $request->published;
                $video->save();
                break;

            default:
                $audio = Audio::find($request->id);
                $audio->title = $request->title;
                $audio->description = $request->description;
                $audio->published = $request->published;
                $audio->save();
                break;
        }
        session()->flash('message',$request->type.' information was successfully uupdated');
        return back();
    }
    public function showAlbum($family,$category,$album_type,$album_name,$album_id)
    {
        return view('gallary::albums.show',['album'=>Album::find($album_id)]);
    }

    public function index($family)
    {
        return view('gallary::index');
    }
}
