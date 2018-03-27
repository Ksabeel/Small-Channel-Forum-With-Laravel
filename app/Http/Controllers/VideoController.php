<?php

namespace App\Http\Controllers;

use App\Http\Requests\VideoUpdateRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
	public function update(VideoUpdateRequest $request, Video $video)
	{
		$this->authorize('update', $video);

		$video->update([
			'title' => $request->title,
			'description' => $request->description,
			'visibility' => $request->visibility,
			'allow_votes' => $request->has('allow_votes'),
			'allow_comments' => $request->has('allow_comments'),
		]);

		if ($request->ajax()) {
			
			return response()->json(null);
		}

		return redirect()->back();
	}

    public function store(Request $request, Video $video)
    {
    	// generate the uid
    	$uid = uniqid(true);

    	// grab the user's channel
    	$channel = $request->user()->channel()->first();

    	// save the videos details
    	$video = $channel->videos()->create([
    		'uid' => $uid,
    		'title' => $request->title,
    		'description' => $request->description,
    		'visibility' => $request->visibility,
    		'video_filename' => "{$uid}.{$request->extension}", 
    	]);

    	return response()->json([200, 'uid' => $uid]);
    }

}
