<?php namespace App\Http\Controllers\Handlers;

use Excel;
use Toast;
use Session;
use File; 

class DownloadHandler {

	/**
	 * Store image to public folder
	 *
	 * @param  file  $file
	 * @return string
	 */
	public function processDownload($data, $filename)
    {
       /* print_r($data);
        exit;*/
        if(isset($data['error']))
        {
            //In case of error, return with $error messages
            Toast::message($data['error'], 'danger');          
        }else
        {
           /* $message = $this->getMessage('messages.download_success');
            Toast::message($message, 'success');      */    
            //Download Excel
            Excel::create($filename, function($excel) use($data)  {
                $excel->sheet('Sheet',  function($sheet) use($data)  {
                    $sheet->fromArray($data);
                });
            })->download('xls');
        }
    }

}
