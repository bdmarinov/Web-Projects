<!DOCTYPE html>
<html>
<head>
	<title>Messenger</title>
	<link rel="stylesheet" href="../library/css/bootstrap.min.css">
	<script src="../library/js/jquery-3.4.1.min.js"></script>
	<style type="text/css">
		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}
		#chat-room-frm {
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2 class="text-center" style="margin-top: 5px; padding-top: 0;">Messenger</h2>
		<hr>
		<div class="row">
			<div class="col-md-4">
				<?php 
				
					require_once 'controllers/authController.php';
					if(!isset($_SESSION['id'])) {
						header("location: testIndex.php");
					}
					require("dbB/users.php");
					require("dbB/chatrooms.php");

					$objChatroom = new chatrooms;
					$chatrooms   = $objChatroom->getAllChatRooms();

					$objUser = new users;
					$users   = $objUser->getAllUsers();
				 ?>
				<table class="table table-striped">
					<thead>
						<tr>
							<td>
								<?php 

								/*foreach ($users as $key => $user) {
									$userId = $key;
									echo '<input type="hidden" name="userId" id="userId" value="'.$key.'">';
							}*/
								
							
									/*foreach ($_SESSION['user'] as $key => $user) {
										$userId = $key;
										echo '<input type="hidden" name="userId" id="userId" value="'.$key.'">';
										echo "<div>".$user['name']."</div>";
										echo "<div>".$user['email']."</div>";
									}*/
								 ?>
							</td>
							<td><align="right" colspan="2">
							<?php 
					  		
							  echo "<tr><td><div><strong>Logged in as: ".$_SESSION['username']."</strong></div><div></td>";
							  echo "<td><input type='button' onclick='goBack()' class='btn btn-warning' id='leave-chat' name='leave-chat'value='Back to home'></td>";
					  		
					  	 ?>
							</td>
						</tr>
						<tr>
							<th colspan="1">User</th>
							<th colspan="1">User email</th>
						</tr>
					</thead>
					<tbody>
						 <?php 
							foreach ($users as $key => $user) {
								//$color = 'color: red';
								//if($user['login_status'] == 1) {
								//	$color = 'color: green';
								//}
								if(!isset($_SESSION['user'][$user['id']])) {
								echo "<tr><td>".$user['username']."</td>";
								echo "<td>".$user['email']."</td>";
								
								//echo "<td><span class='glyphicon glyphicon-user' style='".$color."'></span></td>";
								//echo "<td>".$user['last_login']."</td></tr>";
								}
								$userId = $_SESSION['id'];
								echo '<input type="hidden" name="userId" id="userId" value="'.$userId.'">';
							}
						 ?>
					</tbody>
				</table>
			</div>
			<div class="col-md-8">
				<div id="messages">
					<table id="chats" class="table table-striped">
					  <thead>
					    <tr>
					      <th colspan="4" scope="col"><strong>Chat Room</strong></th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php 
					  		foreach ($chatrooms as $key => $chatroom) {

					  			if($userId == $chatroom['userid']) {
					  				$from = "Me";
					  			} else {
									  $from = $chatroom['username'];
									  //echo $from;
					  			}
					  			echo '<tr><td valign="top"><div><strong>'.$from.'</strong></div><div>'.$chatroom['msg'].'</div><td align="right" valign="top">'.date("d/m/Y h:i:s A", strtotime($chatroom['created_on'])).'</td></tr>';
					  		}
					  	 ?>
					  </tbody>
					</table>
				</div>
					
				<form id="chat-room-frm" method="post" action="">
					<div class="form-group">
                    	<textarea class="form-control" id="msg" name="msg" placeholder="Enter Message"></textarea>
	                </div>
	                <div class="form-group">
	                    <input type="button" value="Send" class="btn btn-success btn-block" id="send" name="send">
	                </div>
			    </form>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function(){
		var conn = new WebSocket('ws://localhost:8080');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
		    console.log(e.data);
		    var data = JSON.parse(e.data);
		    var row = '<tr><td valign="top"><div><strong>' + data.from +'</strong></div><div>'+data.msg+'</div><td align="right" valign="top">'+data.dt+'</td></tr>';
		    $('#chats > tbody').prepend(row);

		};

		conn.onclose = function(e) {
			console.log("Connection Closed!");
		}

		$("#send").click(function(){
			var userId 	= $("#userId").val();
			var msg 	= $("#msg").val();
			var data = {
				userId: userId,
				msg: msg
			};
			conn.send(JSON.stringify(data));
			$("#msg").val("");
		});

		$("#leave-chat").click(function(){
			var userId 	= $("#userId").val();
			$.ajax({
				url:"action.php",
				method:"post",
				data: "userId="+userId+"&action=leave"
			}).done(function(result){
				var data = JSON.parse(result);
				if(data.status == 1) {
					conn.close();
					location = "testIndex.php";
				} else {
					console.log(data.msg);
				}
				
			});
			
		})

		$("#leave-chat").click(function(){
			var userId 	= $("#userId").val();
			$.ajax({
				url:"action.php",
				method:"post",
				data: "userId="+userId+"&action=leave"
			}).done(function(result){
				var data = JSON.parse(result);
				if(data.status == 1) {
					conn.close();
					location = "testIndex.php";
				} else {
					console.log(data.msg);
				}
				
			});
			
		})

		function goBack() {
  window.history.back();
}

	})
</script>
</html>