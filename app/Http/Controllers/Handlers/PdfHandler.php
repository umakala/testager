<?php namespace App\Http\Controllers\Handlers;


use PDF; 

class PdfHandler {

	/**
	 * Create PDF and download it
	 *
	 * @param  int  $id
	 * @return pdf file
	 */
	public function download($id)
	{
		echo $id;
		$item = \App\News::find($id);
		$html = '<h1>'.$item->title.'</h1>';
		$html = $html.'<h5> Reported by '.$item->reporter_email." at ".$item->created_at.'</h5>';
		//$html = $html.'<img src = "'.$item->image.'"/>';		
		$html = $html.'<p>'.$item->text.'</p>';
		$pdf = PDF::loadHTML($html);
		return $pdf->download('news_'.$id.'.pdf');
	}
}
