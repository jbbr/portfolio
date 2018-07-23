<?php

namespace App\Console\Commands;

use App\Media;
use Illuminate\Console\Command;
use Storage;

class CropImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:crop {file?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crop all storage images';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Storage::disk('public')->files('media');
        foreach ($files as $file) {
            Media::processFile($file);
            $info = pathinfo($file);
            echo "{$info['basename']} cropped\n";
        }
    }
}
