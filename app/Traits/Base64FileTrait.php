<?php

namespace App\Traits;


use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Illuminate\Support\Str;
use Image;
use App\Helper\Helper;
use Storage;

trait Base64FileTrait
{
    public function getRandomFileName($destination,$ext)
    {
        $random_file_name =  Str::random(10);
        $file_name = $destination .'/'.$random_file_name.'.'.$ext;
        if(app('files')->exists($file_name)){
            return $this->getRandomFileName($destination,$ext);
        }
        return $random_file_name .'.'.$ext;
    }
   
    public function  _base64fileUpload($base64_file,$storage_path)
    {
        $image = $base64_file;
        // decode the base64 file
       
        //dd($storage_path);
        $image_info = getimagesize($image);
        $raw_image = explode(',',$image)[1];
        //dd($raw_image);
        $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");
        $imageNameJpg = "";
        if($extension == 'png') {
            $image = imagecreatefrompng($image);
            $imageNameJpg = Str::random(10).'.'.'jpeg';
            imagejpeg($image, storage_path('app/public'.$storage_path.'/'.$imageNameJpg) , 85);
            
            $exif = exif_read_data(storage_path('app/public'.$storage_path.'/'.$imageNameJpg) );
            if(!empty($imageNameJpg)) {
                unlink(storage_path('app/public'.$storage_path.'/'.$imageNameJpg)  );
            }
        } else {
            $exif = exif_read_data($image);
        }
        if(!empty($exif['Orientation'])) {
            $image = imagecreatefromjpeg($image);
            switch($exif['Orientation']) {
            case 8:
                $image = imagerotate($image,90,0);
                break;
            case 3:
                $image = imagerotate($image,180,0);
                break;
            case 6:
                $image = imagerotate($image,-90,0);
                break;
            }
        }
        $image = Image::make($image)->orientate(); 
        $image = base64_encode($image);
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image); 
        $image = imagecreatefromstring(base64_decode($image));                
        $imageNameJpg = Str::random(10).'.'.'png';
        imagejpeg($image, storage_path('app/public'.$storage_path.'/') . $imageNameJpg, 85);
        //$image->save(storage_path('app/public'.$storage_path.'/'.$imageNameJpg), 70);
        //\File::put(storage_path('app/public'.$storage_path.'/'.$imageNameJpg), base64_decode($image));
        // $data = base64_decode($image);
        // $img = imagecreatefromstring($data);
        // $imageNameJpg = Str::random(10).'.'.'jpeg';
        // imagejpeg($img, storage_path('app/public'.$storage_path.'/') . $imageNameJpg, 10);

        return $storage_path.'/'. $imageNameJpg;

        // save it to temporary dir first.
        // $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        // file_put_contents($tmpFilePath, $base64File);
        //  // this just to help us get file info.
        // $tmpFile = new File($tmpFilePath);

        // $file = new UploadedFile(
        //     $tmpFile->getPathname(),
        //     $tmpFile->getFilename(),
        //     $tmpFile->getMimeType(),
        //     0,
        //     true // Mark it as test, since the file isn't from real HTTP POST.
        // );

        //return $file->storePublicly($storage_path,'public');
    }

    public function _normalFileUpload($file,$destination,array $extra = null)
    {
      $extension = $file->getClientOriginalExtension();
      $photo_name = $this->getRandomFileName($destination,$extension);
        //   $exif = exif_read_data($file);
        //     if(!empty($exif['Orientation'])) {
        //         switch($exif['Orientation']) {
        //             case 8:
        //                 $file = imagerotate($file,90,0);
        //                 break;
        //             case 3:
        //                 $file = imagerotate($file,180,0);
        //                 break;
        //             case 6:
        //                 $file = imagerotate($file,-90,0);
        //                 break;
        //         }
        //     }
        // $file->move(storage_path('app/public'.$destination),$photo_name);
      $image_resize = Image::make($file->getRealPath()); 
      $image_resize->orientate();            
        //   $image_resize->resize(600, 600, function ($constraint) {
        //         $constraint->aspectRatio();
        //   })->save(storage_path('app/public/'.$destination.'/'.$photo_name),70);
        $image_resize->resize(600, 600, function ($constraint) {
            $constraint->aspectRatio();
        });
        $aws_storage = Storage::disk('s3')->put($destination.'/'.$photo_name, $image_resize->stream()); 
        //$aws_storage = Storage::disk('s3')->put('app/public/'.$destination.'/'.$photo_name, $image_resize->stream()); 
        //dd(Storage::disk('s3')->url($destination.'/'.$photo_name));
        return $destination .'/'.$photo_name;
    }

    public function _deleteFile($file)
    {
      
        return true;
        //$file = str_replace(env('S3_URL'),"",$file);
        //$file_path = parse_url($file);
        //$aws_storage = Storage::disk('s3')->delete($file_path); 
        //dd($aws_storage);
        //return $aws_storage;
    }
    
}
