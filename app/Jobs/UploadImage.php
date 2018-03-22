<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Models\User;
use File;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $channel;

    protected $fileId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get the image from directory
        $path = Storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '_.png'; // Or get the getClientOrginalExtension() and replace with string (_.png)

        // upload to s3 or any other driver you like to use
        if (Storage::disk('your-driver-name')->put('your-folder-name' . $fileName, fopen($path, 'r+'))) {
            
            // then delete image from directory
            File::delete($path);
        }

        // update the image and save to the database
        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
