<?php

namespace App\Http\Controllers;

use Storage;
use Validator;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{

    public function index(Request $request): Response
    {
        $videos = Video::orderBy('id', 'desc')->paginate(10);
        return response($videos);
    }


    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if (!$request->hasFile('video')){
            return response()->json([
                'message' => 'Missing video'
            ], 400);
        }

        $path = $request->file('video')->store('videos', ['disk' => 'myVideos']);

        $user = Video::create([
            'title' => e($request->title),
            'description' => e($request->description),
            'video_name' => $path
        ]);

        return response()->json([
            'message' => 'Video uploaded successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string|max:255',
            'video' => 'file|mimetypes:video/mp4'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $video = Video::findOrFail($id);

        if($request->file('video')){
            $video->video_name = $request->file('video')->store('videos', ['disk' => 'myVideos']);
        }

        if($request->title){
            $video->title = e($request->title);
        }

        if($request->description){
            $video->description = e($request->description);
        }

        $video->save();

        return response()->json([
            'message' => 'Video edited successfully',
            'video' => $video
        ]);

    }

    public function destroy($id)
    {
        $video = Video::find($id);

        File::delete($video->video_name);

        $video->delete();

        return response()->json([
            'message' => 'Video deleted successfully'
        ]);
    }
}
