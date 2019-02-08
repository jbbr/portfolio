<?php

namespace App;

use App\Helper\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Media extends Model
{
    const CONVERT_PDF = 'pdf';
    const CONVERT_DOC = 'doc';
    const MERGE_END = 'end';

    protected $table = "media";

    protected $guarded = ['id'];

    public function mediaInfos()
    {
        return $this->hasMany(MediaInfo::class);
    }

    public function mediaLinked()
    {
        return $this->hasManyThrough(MediaLinked::class, MediaInfo::class);
    }

    /**
     * getRealPath returns the original media path used for export and download
     *
     * @return string
     */
    public function getRealPath()
    {
        return Storage::url($this->path);
    }

    /**
     * imagePath returnes the potentially processed image path used for display on the website
     *
     * @return string
     */
    protected function imagePath()
    {
        if (in_array($this->mime_type, ['image/jpeg', 'image/png', 'video/mp4', 'audio/mpeg', 'audio/ogg'])) {
            return $this->path;
        }
        $segs = explode('.', $this->path);
        $segs[1] = 'jpg';
        return implode('.', $segs);
    }

    /**
     * defaultImage returns either the default image of the mime type or null if the mime type has no default image
     *
     * @return string|null
     */
    public function defaultMimeTypeImage()
    {
        $mimeTypes = Config::get('media.allowedMimeTypes');
        if (!array_key_exists($this->mime_type, $mimeTypes)) {
            return null;
        }
        return $mimeTypes[$this->mime_type];
    }

    /**
     * getImagePath returnes the potentially processed image path used for display on the website
     *
     * @return string
     */
    public function getImagePath($crop = null)
    {
        $path = $this->imagePath();

        if (!is_null($crop) && strpos($path, 'media/') === 0) {
            $path = str_replace('media/', "media/{$crop}/", $path);

            $info = pathinfo($path);
            $path = "{$info['dirname']}/{$info['filename']}.jpg";
        }

        if (strpos($path, 'media/') === 0) {
            $path = Storage::url($path);
        }

        return $path;
    }

    public function getQrCode()
    {

        $path = str_replace('media/', "media/qrcodes/", $this->imagePath());

        $info = pathinfo($path);
        $path = "{$info['dirname']}/{$info['filename']}.png";

        return Storage::url($path);
    }

    public function isMultimedia()
    {
        return $this->isVideo() || $this->isAudio();
    }

    public function isVideo()
    {
        if (strpos($this->mime_type, 'video/') === 0) {
            return true;
        }
        return false;
    }

    public function isAudio()
    {
        if (strpos($this->mime_type, 'audio/') === 0) {
            return true;
        }
        return false;
    }

    // Accessor
    public function getSizeAttribute($value)
    {
        return Utils::bytesToHuman($value);
    }

    public static function cropImage($src, $dst)
    {
        $mediaPath = storage_path('app/public/media/');

        foreach (Config::get('media.cropSizes') as $id => $size) {
            $dstPath = $mediaPath . $id . '/';
            $_src = $mediaPath . $src;
            $_dst = $dstPath . $dst;

            try {
                mkdir($dstPath);
            } catch (\Exception $e) {
            }

            $width = escapeshellarg($size['width']);
            $height = escapeshellarg($size['height']);
            $_src = escapeshellarg($_src);
            $_dst = escapeshellarg($_dst);

            if ($id == 'original') {
                shell_exec("convert {$_src} -resize {$height} -quality 95 {$_dst}");
            } else {
                shell_exec(base_path() . "/node_modules/smartcrop-cli/smartcrop-cli.js --width {$width} --height {$height} {$_src} {$_dst}");
            }
        }
    }

    public static function convertDocument($src, $dst, $type = self::CONVERT_PDF)
    {
        $path = storage_path('app/public/media/');
        $srcpath = $path . $src;
        $dstpath = $path . $dst;

        if ($type == self::CONVERT_PDF) {
            shell_exec('convert -density 150 -trim ' . escapeshellarg($srcpath . '[0]') . ' -quality 100 -flatten -sharpen 0x1.0 ' . escapeshellarg($dstpath));
        } else {
            if ($type == self::CONVERT_DOC) {
                shell_exec('export HOME=/tmp && /usr/bin/soffice --headless --convert-to pdf ' . escapeshellarg($srcpath) . ' --outdir ' . escapeshellarg($path));
            }
        }
    }

    public static function convertAttachment($src, $dst, $copy = false)
    {
        $path = storage_path('app/public/media/');
        $srcpath = $path . $src;
        $dstpath = $path . 'attachment/' . $dst;

        try {
            mkdir($path . 'attachment');
        } catch (\Exception $e) {
        }

        if ($copy) {
            copy($srcpath, $dstpath);
        } else {
            shell_exec('convert -units pixelsperinch -density 72 ' . escapeshellarg($srcpath) . ' -resize \'565x823>\' -gravity Center -background white -extent 595x842 ' . escapeshellarg($dstpath));
        }
    }

    public static function convertVideo($src, $dst)
    {
        $path = storage_path('app/public/media/');
        $srcpath = $path . $src;
        $dstpath = $path . $dst;

        rename($srcpath, $srcpath . '-unprocessed');

        shell_exec('ffmpeg -y -i ' . escapeshellarg($srcpath . '-unprocessed') . ' -vcodec h264 -acodec aac -strict -2 ' . escapeshellarg($dstpath));

        unlink($srcpath . '-unprocessed');
    }

    public static function convertAudio($src, $dst)
    {
        $path = storage_path('app/public/media/');
        $srcpath = $path . $src;
        $dstpath = $path . $dst;

        rename($srcpath, $srcpath . '-unprocessed');

        shell_exec('ffmpeg -y -i ' . escapeshellarg($srcpath . '-unprocessed') . '  -vn -ar 44100 -ac 2 -ab 192k -f mp3 ' . escapeshellarg($dstpath));

        unlink($srcpath . '-unprocessed');
    }

    public static function generateVideoThumbnail($src, $dst)
    {
        $path = storage_path('app/public/media/');
        $srcpath = $path . $src;
        $dstpath = $path . 'video_thumbnails/' . $dst;

        try {
            mkdir($path . 'video_thumbnails/');
        } catch (\Exception $e) {
        }

        shell_exec('ffmpeg -ss 3 -i ' . escapeshellarg($srcpath) . ' -vf "select=gt(scene\,0.4)" -frames:v 5 -vsync vfr -vf fps=fps=1/600 ' . escapeshellarg($dstpath));
    }

    public static function generateQRCode($src, $dst)
    {
        $path = storage_path('app/public/media/');
        $dstpath = $path . 'qrcodes/' . $dst;

        try {
            mkdir($path . 'qrcodes/');
        } catch (\Exception $e) {
        }

        QrCode::format('png')
            ->size(200)
            ->encoding('UTF-8')
            ->generate(asset(Storage::url('media' . DIRECTORY_SEPARATOR . $src)),$dstpath );

        // Write into QR-Codes Folder
//        $fh = fopen($dstpath, "w+");
//        fwrite($fh, $png);
//        fclose($fh);
    }

    public static function mergePDFs($options, $outfile)
    {
        // Gather all files
        $files = [];
        foreach ($options as $option) {
            $files[] = array_keys($option)[0];
        }
        $files = array_values(array_unique($files));

        // Map Files to letters
        $letters = [];
        $currLetter = 'A';
        for ($i = 0; $i < count($files); $i++) {
            $letters[$files[$i]] = $currLetter;
            $currLetter++;
        }
        $files = array_combine($files, $letters);

        // Write letter file cmd
        $cmd = 'pdftk ';
        foreach ($files as $file => $letter) {
            $cmd .= "$letter=" . escapeshellarg($file) . ' ';
        }

        $cmd .= 'cat ';

        // Write ranges to cmd
        foreach ($options as $option) {
            $file = array_keys($option)[0];
            $range = array_values($option)[0];

            if (count($range) == 1) {
                $cmd .= $letters[$file] . $range[0] . ' ';
            } else {
                $cmd .= $letters[$file] . $range[0] . '-' . $range[1] . ' ';
            }
        }

        $cmd .= 'output ' . escapeshellarg(storage_path('app/pdf/') . $outfile);
        shell_exec($cmd);
    }

    public static function processFile($filename)
    {
        $info = pathinfo($filename);

        $ext = strtolower($info['extension']);
        $name = $info['filename'];
        $mimetype = mime_content_type(storage_path('app/public/media/') . "$name.$ext");
        $cropfile = "$name.$ext";
        $crop = true;

        switch ($mimetype) {
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                Media::convertDocument("$name.$ext", "$name.pdf", Media::CONVERT_DOC);
            case 'application/pdf':
                Media::convertDocument("$name.pdf", "$name.jpg", Media::CONVERT_PDF);
                $cropfile = "$name.jpg";
                break;
            case 'video/mp4':
                Media::convertVideo("$name.$ext", "$name.mp4");
                Media::generateVideoThumbnail("$name.mp4", "$name.jpg");
                Media::generateQRCode($name . ".mp4", $name . ".png");

                // Change path for attachment convertion
                $_convertionPath = "qrcodes" . DIRECTORY_SEPARATOR . $name . ".png";
                $crop = false;
                break;
            case 'audio/mpeg':
            case 'audio/ogg':
                Media::convertAudio("$name.$ext", "$name.mp3");
                Media::generateQRCode("$name.$ext", $name . ".png");

                // Change path for attachment convertion
                $_convertionPath = "qrcodes" . DIRECTORY_SEPARATOR . $name . ".png";
                $crop = false;
                break;
        }

        switch ($mimetype) {
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/pdf':
                Media::convertAttachment("$name.pdf", "$name.pdf", true);
                break;
            case 'video/mp4':
            case 'audio/mpeg':
            case 'audio/ogg':
                Media::convertAttachment($_convertionPath, "$name.pdf");
                break;
            default:
                Media::convertAttachment("$name.$ext", "$name.pdf");
                break;
        }

        if ($crop) {
            Media::cropImage($cropfile, "$name.jpg");
        }
    }
}

