<?php



Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat',function($user){
	return ['name'=>$user->name];
});




Broadcast::channel('privateMessage.{to_user}', function ($user,$to_user) {
    return auth()->check();
});

