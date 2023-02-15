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

    public function index(): Response
    {
        $videos = Video::all();
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


    public function store(Request $request): RedirectResponse
    {
        //
    }

    public function show(Video $video): Response
    {
        //
    }

    public function edit(Video $video): Response
    {
        //
    }

    public function update(Request $request, Video $video): RedirectResponse
    {
        //
    }

    public function destroy(Video $video): RedirectResponse
    {
        //
    }
}
