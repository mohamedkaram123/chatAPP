<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\PrivateChat;

use App\User;
use App\Message;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function chat()
    {
    	return view('chat');
    }

    public function send(request $request)
    {
		
		Message::create([
		"from_user"=>Auth::id(),
		"content"=>$request->message
	]);
    	$user = User::find(Auth::id());
    //	$this->saveToSession($request);
    	event(new ChatEvent($request->message,$user,'mesage'));
	}


	public function uploadrecordpublic(request $request)
{
	

	$record = $this->save_file($request->file('audio_data'), '/records');
Message::create([
		"from_user"=>Auth::id(),
		"record"=>$record
	]);
    	$user = User::find(Auth::id());

	event(new ChatEvent($record,$user,'record'));

}
	

public function uploadfilespublic(request $request)
{
	

	$file = $this->save_file($request->file('file'), '/files');
Message::create([
		"from_user"=>Auth::id(),
		"files"=>$file
	]);
    	$user = User::find(Auth::id());

	event(new ChatEvent($file,$user,'files'));

}




public function save_file($file,$folder='/'){
    $extension = $file->getClientOriginalExtension(); // getting image extension
    $fileName = time() . '' . rand(11111, 99999) .'.'. $extension; // renameing image
    $dest = public_path('/uploads'.$folder);
	$file->move($dest, $fileName);
	
//	public_path('/uploads'.$folder . '/' . $fileName)
    return    'public/uploads'.$folder . '/' . $fileName;
}

	public function loadmasseges()
	{
	$allmsg = Message::where("to_user",null)->get();
$arrayallmsg = [];
	foreach ($allmsg as $msg ) {
		$user = User::find($msg->from_user)->name;
$msg["name"] = $user;

	}
	return ["id"=>Auth::id() ,"allmsg"=>$allmsg];
	}
 
public function loadusers()
{
$users = 	User::where('id','!=',Auth::id())->get();

return $users;
}



public function sendprivate(request $request)
{

$message = 	Message::create([
		"from_user"=>Auth::id(),
		"to_user" =>$request->to_user,
		"content"=>$request->message
	]);
	$user = User::find(Auth::id());

	//$message["name"] = $user->name;

	
    	event(new PrivateChat($message,$user,'mesage'));

}



public function uploadrecordprivate(request $request)
{
	

	$record = $this->save_file($request->file('audio_data'), '/records');
	$message = Message::create([
		"from_user"=>Auth::id(),
		"to_user" =>$request->to_user,
		"record"=>$record
	]);
	$user = User::find(Auth::id());

	event(new PrivateChat($message,$user,'record'));

}




public function uploadfileprivate(request $request)
{
	

	$file = $this->save_file($request->file('file'), '/files');
	$message = Message::create([
		"from_user"=>Auth::id(),
		"to_user" =>$request->to_user,
		"files"=>$file
	]);
	$user = User::find(Auth::id());

	event(new PrivateChat($message,$user,'files'));

}


public function clearchatingprivate(request $request)
{
	

	$allmsgfrom = Message::
	where(function ($q) use ($request) {
		$q->where("from_user",Auth::id());
		$q->where('to_user', $request->to_user);

	})->get();


	foreach ($allmsgfrom as $msg) {
		$msg->update(["clear_chat_user1"=>1]);
			}

			$allmsgto = Message::	
	where(function ($q) use ($request) {
		$q->where("to_user",Auth::id());
		$q->where('from_user', $request->to_user);

	})
	->get();
	foreach ($allmsgto as $msgto) {
		$msgto->update(["clear_chat_user2"=>1]);
			}


	return "done";
}



public function loadmassegesprivate(request $request)
{
$allmsg = Message::where("from_user",Auth::id())
->where("clear_chat_user1",0)
->where("to_user",$request->reciver_id)
->orWhere("to_user",Auth::id())
->where("clear_chat_user2",0)
->Where("from_user",$request->reciver_id)
->get();
$arrayallmsg = [];
foreach ($allmsg as $msg ) {
	$user = User::find($msg->from_user)->name;
$msg["name"] = $user;

}
return ["id"=>Auth::id() ,"allmsg"=>$allmsg];
}

}
