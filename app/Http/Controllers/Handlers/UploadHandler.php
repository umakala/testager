<?php namespace App\Http\Controllers\Handlers;


use Image; 

class UploadHandler {

	/**
	 * Store image to public folder
	 *
	 * @param  file  $file
	 * @return string
	 */
	public function upload($file)
	{
		$url = "";
		if ($file != null) {      		
        	$ext                = $file->getClientOriginalExtension();            
            $valid_img_exts     = array('jpeg','jpg','png','gif','bmp');
            if (in_array($ext, $valid_img_exts))
            { 
            	$path       = "images/news/";
                $dt         = new \DateTime();        
                $imagename  = $dt->format('dmy_His'); 
                $img_name   =$imagename . "." . $ext;
                $base_url   =url('assets/images/news/');              
                $image 		= Image::make($file);
                $image->orientate();
                $image->encode('jpg');
                \Storage::disk('public')->put($path.$img_name, $image->__toString(),'public');
                $url  = $base_url."/".$img_name;                
            }
        }
        return $url;		      
	}
}
