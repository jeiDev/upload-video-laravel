<?php

namespace App\Http\Controllers;

use Storage;
use Validator;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{

    public function index(Request $request): Response
    {
        $videos = Video::orderBy('id', 'desc')->paginate(1);
        return response($videos);
    }


    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        if (!$request->hasFile('video')){
            return response()->json([
                'message' => 'Missing video'
            ], 500);
        }

        $path = $request->file('video')->store('videos', ['disk' => 'myVideos']);

        $user = Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_name' => $path
        ]);

        return response()->json([
            'message' => 'Video uploaded successfully'
        ]);
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string|max:255',
            'video' => 'file|mimetypes:video/mp4'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

    }

    public function destroy(Video $video): RedirectResponse
    {
        //
    }
}
