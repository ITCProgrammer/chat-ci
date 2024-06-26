<?php

if (isset($_SESSION)) {
	$image = $_SESSION['image'];
	$name = $data[0]['user_fname']." ".$data[0]['user_lname'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/message/messagestyle.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="../assets/css/message/loading-bar.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<style>
		body {
			background-color: #f5f5f5;
		}
		#main {
			margin-top: 30px;
		}
		#owner_profile_details {
			display: flex;
			align-items: center;
			background-color: #fff;
			padding: 15px;
			border-radius: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}
		#owner_avtar {
			width: 60px;
			height: 60px;
			border-radius: 50%;
			background-position: center;
			background-size: cover;
			position: relative;
			margin-right: 15px;
		}
		#online {
			width: 15px;
			height: 15px;
			background-color: #4caf50;
			border-radius: 50%;
			border: 2px solid #fff;
			position: absolute;
			bottom: 0;
			right: 0;
		}
		#search_box_container {
			margin-top: 20px;
		}
		#user_list {
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			padding: 15px;
		}
		#chatbox {
			margin-top: 20px;
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
			padding: 15px;
		}
		.chatting_section #header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 1px solid #e0e0e0;
			padding-bottom: 10px;
		}
		#textBox_attachment_emoji_container {
			display: flex;
			align-items: center;
		}
		#text_box_message {
			flex-grow: 1;
			margin-right: 10px;
		}
		#sendButtonContainer button {
			background-color: #4caf50;
			color: white;
			border: none;
			border-radius: 50%;
			padding: 10px 15px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		}
		#sendButtonContainer button:hover {
			background-color: #45a049;
		}
	</style>
	<title>Chat Application ITTI</title>
</head>
<body>
	<section id="main" class="bg-dark">
		<div id="chat_user_list">
			<div id="owner_profile_details">
				<div id="owner_avtar" style="background-image: url('../upload/<?php echo $image;?>'); background-size: 100% 100%">
					<div>
						<div id="online"></div>
					</div>
				</div>
				<div id="owner_profile_text" class="">
					<h6 id="owner_profile_name" class="m-0 p-0"><?php echo $name;?></h6>
					<div id="bio">
						<p id="owner_profile_bio" class="m-0 p-0"></p>
						<i class="fas fa-edit" id="edit_icon"></i>
					</div>
					<a class="text-decoration-none" href="" id="logout" style="color:#e86663;"><i class="fa fa-power-off"></i> Logout</a>
				</div>
			</div>
			<button style="border-radius: 10px;" onclick="refreshPage()">cek pesan</button>
			<div id="search_box_container" class="py-3">
				<input type="text" name="txt_search" class="form-control" autocomplete="off" placeholder="Search User" id="search">
			</div>
			<hr/>
			<?php
			// Lakukan query untuk memeriksa jumlah pesan yang belum dibaca
			$current_user_id = $_SESSION['uniqueid']; // Sesuaikan dengan kolom dan nama sesuai kebutuhan
			$query = "SELECT COUNT(*) AS unread_count FROM user_messages WHERE receiver_message_id = '$current_user_id' AND status = 'unread'";
			$result = $this->db->query($query);
			$row = $result->row();
			$unread_count = $row->unread_count;

			// Jika ada pesan yang belum dibaca, munculkan notifikasi sebagai div
			if ($unread_count > 0) {
				echo "<div id='unread_notification'>Anda memiliki $unread_count pesan belum dibaca</div>";
			}
			?>
			<script>
				// Cek apakah elemen notifikasi ada, jika tidak, sembunyikan
				var notification = document.getElementById('unread_notification');
				if (!notification) {
					notification.style.display = 'none';
				}
			</script>
			<script>
				function refreshPage() {
					location.reload();
				}
			</script>
			<div id="user_list" class="py-3">
			</div>
		</div>
		<!-- <button id="hideChatButton" class="btn btn-primary">Hide Chat</button> -->
		<div id="chatbox">
			<div id="data_container" class="">
				<div id="bg_image"></div>
				<h2 class="mt-0">Hi There! Welcome To</h2>
				<h2>Chat Application ITTI</h2>
				<!-- <p class="text-center my-2">Connect to your device via Internet. Remember that you <br> must have a stable Internet Connection for a<br> greater experience.</p> -->
			</div>
			<div class="chatting_section" id="chat_area" style="display: none">
				<div id="header" class="py-2">
					<div id="name_details" class="pt-2">
						<div id="chat_profile_image" class="mx-2" style="background-size: 100% 100%">
							<div id="online"></div>
						</div>
						<div id="name_last_seen">
							<h6 class="m-0 pt-2"></h6>
							<p class="m-0 py-1"></p>
						</div>
					</div>
					<div id="icons" class="px-4 pt-2">
						<div id="send_mail">
							<a href="" id="hideChatButton"><i class="fa-sharp fa-solid fa-xmark"></i></i></a>
						</div>
						<div id="details_btn" class="ml-3">
							<i class="fas fa-info-circle text-dark"></i>
						</div>
					</div>
				</div>
				<div id="chat_message_area">

				</div>
				<div id="messageBar" class="py-4 px-4">
					<div id="textBox_attachment_emoji_container">
						<div id="text_box_message">
							<input type="text" maxlength = "200" name="txt_message" id="messageText" class="form-control" placeholder="Type your message">
						</div>
						<div id="text_counter">
							<p id="count_text" class="m-0 p-0"></p>
						</div>
					</div>
					<div id="sendButtonContainer">
						<button class="btn" id="send_message">
							<span class="material-icons">send</span>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div id="details_of_user">
			<div id="user_details_container_avtar" style="background-size: 100% 100%"></div>
			<h5 class="text-justify" id="details_of_name"></h5>
			<p class="text-justify" id="details_of_bio"></p>
			<div id="user_details_container_details">
				<p class="text-justify" id="details_of_created"></p>
				<p class="text-justify" id="details_of_birthday"></p>
				<p class="text-justify" id="details_of_mobile"><span></p>
				<p class="text-justify" id="details_of_email"><span></p>
				<p class="text-justify" id="details_of_location"><span></p>
			</div>
			<button class="btn btn-danger" id="btn_block">Block User</button>
		</div>
	</section>
	<div id="update_container">
		<div style="background-color:#F5F6FA;" class="p-3 d-flex justify-content-between align-items-center">
			<h5 id="update_container_title" class="m-0 p-0">Update Profile</h5>
			<i class="fas fa-times"></i>
		</div>
		<form class="" id="form_details" autocomplete="off">
			<div class="form-group">
				<label>Date Of Birth</label>
				<input type="text" name="txt_dob" id="dob" class="form-control" placeholder="dd-mm-yyyy">
			</div>
			<div class="form-group">
				<label>Contact Number</label>
				<input type="text" maxlength="10" name="txt_phone" placeholder="Write your mobile number" id="phone_num" class="form-control">
			</div>
			<div class="form-group">
				<label>Address</label>
				<input type="text" name="txt_addr" id="address" placeholder="Write your address" class="form-control">
			</div>
			<div class="form-group">
				<label>Bio</label>
				<textarea name="bio" class="" id="update_bio" placeholder="Write your bio here.."></textarea>
			</div>
			<button class="btn btn-block" id="update_btn" style="border-radius:0px;">
				<span>Save Changes</span>
			</button>
		</form>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
	<script type="text/javascript" src="../assets/js/message/main.js"></script>
	<script>
		// Fungsi untuk menyembunyikan chat
		$(document).ready(function(){
			$("#hideChatButton").click(function(){
				$("#chat_area").hide();
			});
		});
	</script>
</body>
</html>