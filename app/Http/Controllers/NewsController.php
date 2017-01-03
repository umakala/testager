<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use  App\Http\Controllers\Handlers\UploadHandler;
use  App\Http\Controllers\Handlers\PdfHandler;
use Illuminate\Http\Request;

class NewsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$news = array();
		if(session()->has('email')){
	  		$email = session()->get('email');
	  		//$news    = \App\News::where('reporter_email' , $email)->orderBy('created_at', 'desc')->limit(10)->get();
		}
		else{
			//$news    = \App\News::orderBy('created_at', 'desc')->limit(10)->get();
		}
		if(isset($_GET['info']))
			return view('welcome', ['list' => $news, 'info' => $_GET['info'] ]);
		if(isset($_GET['message']))
			return view('welcome', ['list' => $news, 'message' => $_GET['message'] ]);
		else
			return view('welcome', ['list' => $news]);	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('news');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//Validations
		$validator = \Validator::make($request->all(), array(
			'title' => 'required',
			'text' => 'required'            
			));
		if ($validator->fails())
		{
			foreach ($validator->errors()->toArray() as $key => $value) {
				$error[]=$value[0];
			} 
		}
		else{
			if( session()->has('email')){
				//Process when validations pass
				$content['title']                 	= $request->title;
		        $content['reporter_email'] 			= session()->get('email');
		        $content['text']                   	= $request->text;
		        $file  								= $request->file('file');
		        $upload_obj 						= new UploadHandler();
				$content['image']                   = $upload_obj->upload($file);
		      
		        $create_news = \App\News::create($content);
			 	return redirect()->route('home');
		 	}else
		 	{
		 		$error[] = "Session expired. Please login to continue";
		 	}
	 	}
	 	return redirect()->route('news', ['message' => $error])->withInput();
	}
	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$item = \App\News::find($id);
        if($item){
			return view('article', [ 'item' => $item]);
        }
		else
			$message = "Could not find news article";
		return redirect()->route('home', ['info' => $message]);        
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if( session()->has('email')){			
		$item = \App\News::find($id);
        if($item){
			$item->delete();
			$message = "News article deleted successfully.";
        }
		else
			$message = "Could not delete. News Article not found!";
		}else{
			$message = "Session expired. Please login to continue.";
		}
		return redirect()->route('home', ['info' => $message]);
	}


	public function download($id)
	{
		$pdf_obj = New PdfHandler();
		return $pdf_obj->download($id);
	}
}
