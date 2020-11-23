<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<link rel="stylesheet" href="{{ url('public') }}/css/app.css">

	<style>
		.list-group{
			overflow-y: scroll;
			height: 350px;
		}

		.m-topbar .m-topbar__nav.m-nav {
    margin: 0 0px 0 20px;
}

* {
  scrollbar-width: thin;
  scrollbar-color: #6c757d #eee;
  
  
}
*::-webkit-scrollbar {
  width: 12px;
}
*::-webkit-scrollbar-track {
  background: #eee;
}
*::-webkit-scrollbar-thumb {
  background-color: #6c757d;
  border-radius: 20px;
  border: 3px solid #eee;

}

#icon:hover{
	color: rgb(26, 115, 232)
}

#icon{
	cursor: pointer;
}

	</style>
</head>
<body>
	
	<div style="float: right;margin-right: 20px" >

		<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
			@csrf
			<button id="btn_logout"></button>
		</form>
		<i id="icon" style="font-size: 50px" class="fa fa-sign-out" aria-hidden="true"></i>
	</div>
	<div class="container">
		<div class="row" id="app" style="margin: 30px"  ref="name"	data-names="{{auth()->user()->name}}" 	>

			<div class="col-md-4" style="padding: 0">
				<ul class="list-group">
				    <div>

						<div><label style="background: #2d995b;font-weight: bold;color:#fff" class="list-group-item">welcome : {{auth()->user()->name}}</label></div>


						<a  >
									<li :style="stylss"  @click="loadmsgs"   @mouseover="hoverss" @mouseleave="blurss"  class="list-group-item">Public</li>
					   
						</a>
					   
							
						   </div>
						   
					<user
					v-for="(user,index) in chat.usersbar"
					:key=user.index
					:user_id="user.id"  
					:username="user.name"
					ref="user"
					@update="getchatfrindes"
					>
						@{{ user.name }}
				</user>
			
				  </ul>
			</div>
	
			<div class="col-md-8  " style="padding: 0;">
				<li class="list-group-item active">@{{chatName}}  </li>
				<div class="badge badge-pill badge-primary"></div>
				<div class="list-group" v-if="img_load"><img src="http://127.0.0.1/img/load.gif" style="width: 50px;height: 50px;position: relative;top:70px;left:300px" /></div>

				<div v-else>
				<ul 	  id="messages" class="list-group"  v-chat-scroll>
				
                 
				  <message
				  v-for="(value,index) in chat.message"
				  :key=value.index
				  :color="chat.color[index]" 
				  :checkvalue="value"
				:user="chat.user[index]"

				  >
				  	@{{ value.content }}
				  </message>


		
				</ul>
				</div>
				  <input type="text" class="form-control" placeholder="Type your message here..." v-model='message' @keyup.enter='send'>
				 
				  <br>
				 <div style="display: none">
					<input type="file" @change="uploadfile"   id="myfile" name="myfile">

				</div>
				  <a href='' @click="clearChat" class="btn btn-warning btn-sm">Delete Chats</a>
				  <a href='' @click="startRecording" id="record" class="btn btn-danger btn-sm">record</a>
				  <a href='' @click="trigger" id="uploadfile" class="btn btn-success btn-sm">upload file</a>

			</div>
		</div>
	</div>

	<script src="https://cdn.rawgit.com/mattdiamond/Recorderjs/08e7abd9/dist/recorder.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="{{ url('public') }}/js/app.js"></script>
<script>
$("#icon").click(function(){
	$("#btn_logout").trigger("click");

})
</script>
</body>
</html>