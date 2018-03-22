<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingController extends Controller
{
    public function edit(Channel $channel)
    {
    	$this->authorize('edit', $channel);
    	return view('channel.settings.edit')->with('channel', $channel);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
    	$this->authorize('update', $channel);

        if ($request->hasFile('image') && $request->image->isValid()) {

            // for local storage, use this
            $image = $request->file('image');
            $filename = time() . '_.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('/uploads'), $filename);


            // for online storage,  use this and remove the local storage setup
            //$request->image->move(storage_path() . '/uploads/', $fileId = uniqid(true));

            // then dispatch
            //$this->dispatch(new UploadImage($channel, $fileId));
        }

    	$channel->update([
    		'name' => $request->name,
    		'slug' => $request->slug,
    		'description' => $request->description,
            // if you use online storage then remove the image_filename
            'image_filename' => $filename,
    	]);

    	return redirect()->route('channel.edit', $channel->slug);
    }
}
