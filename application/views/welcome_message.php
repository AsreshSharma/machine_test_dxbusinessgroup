<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Machine Test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style>
		.btn-center{
			text-align:center;
		}
		.container-fluid{
			padding:20px 10px;
		}
		.margintop{
			margin-top:20px;
		}
	</style>
</head>
<body class="container-fluid">

	<div class="row" id="user" style="display:none;">
		<div class="col-md-3">
			<form method="post">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Enter User Name" id="user_name" />
				</div>
				<div class="form-group btn-center">
					<a href="javascript:void(0)" onclick="saveUser()" class="btn btn-info">Next</a>
				</div>
			</form>
		</div>		
		<div class="col-md-9">
			<strong>Your Start Quiz!. <span style="font-size:11px; font-weight: 400;">First Enter Your User Name after Start...<span></strong>
		</div>
	</div>

	<div class="row" id="question" style="display:none;">	
		<div class="col-md-3">
			Welcome, <strong><span id="q_username"></span></strong>
			<br>
			<span onclick="logout()" class="btn btn-alert">Logout</span>
		</div>	
		<div class="col-md-9" style="border-left:1px solid;">
			<h5 class="btn-center"> Question <span id="userCount">0</span>/<span id="allqCount">0</span></h5>
			<span id="displayquestion"></span>
		</div>
	</div>

	<div class="row" id="result" style="display:none;">		
		<div class="col-md-3">
			Welcome, <strong><span id="r_username"></span></strong>
			<br>
			<span onclick="logout()" class="btn btn-alert">Logout</span>
		</div>		
		<div class="col-md-9" style="border-left:1px solid;">
			<h4>Result </h4>
			<div class="row">
				<div class="col-md-6">Correct Answer: </div>
				<div class="col-md-6">( <span id="correctans">0</span> )</div>
			</div>
			<div class="row">
				<div class="col-md-6">Wrong Answer: </div>
				<div class="col-md-6">( <span id="wrongans">0</span> )</div>
			</div>
			<div class="row">
				<div class="col-md-6">Skip Answer: </div>
				<div class="col-md-6">( <span id="skipans">0</span> )</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>		
		var next=1;
		var allquestion=0;
		$(document).ready(function(){
			countquestion();
		});

		setInterval(function(){ 
			let check=localStorage.getItem("next");
			if(check > 0){
				next=check;
			}
			$("#userCount").text(next);
		}, 1000);

		function checkuser(){			
			var id=localStorage.getItem("id");
			if(id > 0){		
				var newQ=localStorage.getItem("allquestion");
				if(next==newQ){					
					showresult();
				}	
				else if(next < newQ){
					$("#user").hide();
					$("#question").show();
					$("#result").hide();
					$("#q_username").text(localStorage.getItem("user_name"));
					let check=localStorage.getItem("next");
					if(check > 0){
						next=check;
					}
					$("#userCount").text(next);
					getquestion();
				}
				else{
					showresult();
				}
			}
			else{
				$("#user").show();
				$("#question").hide();
				$("#result").hide();
			}
		}

		function getquestion(){
			var newQ=localStorage.getItem("allquestion");		
			if(next==newQ){
				showresult();
			}	
			else{
				$.ajax({
					url:"<?=site_url("Welcome/getquestion");?>",
					method:"post",
					data:{
						next:next
					},
					success:function(res){
						var obj=JSON.parse(res);
						if(obj.status=="1"){
							var htmlCode='<div class="row">';
								htmlCode+='<div class="col-md-12"><p> '+obj.data.question+'</p><input type="hidden" id="question_id" value="'+obj.data.id+'"></div>';
								htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option1+'"> &nbsp; <label for="'+obj.data.option1+'">'+obj.data.option1+'</label></div>';
								htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option2+'"> &nbsp; <label for="'+obj.data.option2+'">'+obj.data.option2+'</label></div>';
								htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option3+'"> &nbsp; <label for="'+obj.data.option3+'">'+obj.data.option3+'</label></div>';
								htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option4+'"> &nbsp; <label for="'+obj.data.option4+'">'+obj.data.option4+'</label></div>';
								htmlCode+='<div class="col-md-12 margintop"><a class="btn btn-info" href="javascript:void(0);" onclick="skipquestion()"> Skip </a>  &nbsp; <a class="btn btn-success" href="javascript:void(0)" onclick="nextquestion()"> Next </a></div>';
							htmlCode+='</div>';						
							$("#displayquestion").html(htmlCode);
						}
						else{
							alert("Question not found!");
						}
					},
					error:function(err){
						console.log(err);
					}
				});
			}
		}

		function nextquestion(){
			var newQ=localStorage.getItem("allquestion");		
			if(next==newQ){
				showresult();
			}	
			else{
				var question_id=$("#question_id").val();
				var user_id=localStorage.getItem("id");
				var user_ans=$("input[name='user_ans']:checked").val();
				if(user_ans==undefined || user_ans==null || user_ans==""){
					alert("Please click any one answer");
				}
				else{
					$.ajax({
						url:"<?=site_url("Welcome/nextquestion");?>",
						method:"post",
						data:{
							next:next,
							question_id:question_id,
							id:user_id,
							user_ans:user_ans
						},
						success:function(res){
							var obj=JSON.parse(res);
							if(obj.status=="1"){
								next++;
								localStorage.setItem("next",next);
								if(next < allquestion){
									var htmlCode='<div class="row">';
										htmlCode+='<div class="col-md-12"><p> '+obj.data.question+'</p><input type="hidden" id="question_id" value="'+obj.data.id+'"></div>';
										htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option1+'"> &nbsp; <label for="'+obj.data.option1+'">'+obj.data.option1+'</label></div>';
										htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option2+'"> &nbsp; <label for="'+obj.data.option2+'">'+obj.data.option2+'</label></div>';
										htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option3+'"> &nbsp; <label for="'+obj.data.option3+'">'+obj.data.option3+'</label></div>';
										htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option4+'"> &nbsp; <label for="'+obj.data.option4+'">'+obj.data.option4+'</label></div>';
										htmlCode+='<div class="col-md-12 margintop"><a class="btn btn-info" href="javascript:void(0);" onclick="skipquestion()"> Skip </a>  &nbsp; <a class="btn btn-success" href="javascript:void(0)" onclick="nextquestion()"> Next </a></div>';
									htmlCode+='</div>';						
									$("#displayquestion").html(htmlCode);
								}
								else{
									showresult();
								}
							}
							else{
								alert("Question not found!");
							}
						},
						error:function(err){
							console.log(err);
						}
					});
				}
			}
		}

		function skipquestion(){
			var newQ=localStorage.getItem("allquestion");		
			if(next==newQ){
				showresult();
			}	
			else{
				var question_id=$("#question_id").val();
				var user_id=localStorage.getItem("id");
				$.ajax({
					url:"<?=site_url("Welcome/skipquestion");?>",
					method:"post",
					data:{
						next:next,
						question_id:question_id,
						id:user_id
					},
					success:function(res){
						var obj=JSON.parse(res);
						if(obj.status=="1"){
							next++;
							localStorage.setItem("next",next);
							if(next < allquestion){
								var htmlCode='<div class="row">';
									htmlCode+='<div class="col-md-12"><p> '+obj.data.question+'</p><input type="hidden" id="question_id" value="'+obj.data.id+'"></div>';
									htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option1+'"> &nbsp; <label for="'+obj.data.option1+'">'+obj.data.option1+'</label></div>';
									htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option2+'"> &nbsp; <label for="'+obj.data.option2+'">'+obj.data.option2+'</label></div>';
									htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option3+'"> &nbsp; <label for="'+obj.data.option3+'">'+obj.data.option3+'</label></div>';
									htmlCode+='<div class="col-md-12"><input type="radio" id="user_ans" name="user_ans" value="'+obj.data.option4+'"> &nbsp; <label for="'+obj.data.option4+'">'+obj.data.option4+'</label></div>';
									htmlCode+='<div class="col-md-12 margintop"><a class="btn btn-info" href="javascript:void(0);" onclick="skipquestion()"> Skip </a>  &nbsp; <a class="btn btn-success" href="javascript:void(0)" onclick="nextquestion()"> Next </a></div>';
								htmlCode+='</div>';						
								$("#displayquestion").html(htmlCode);
							}
							else{
								showresult();
							}
						}
						else{
							alert("Question not found!");
						}
					},
					error:function(err){
						console.log(err);
					}
				});
				
					
			}
		}


		function saveUser(){
			var user_name=$("#user_name").val();
			$.ajax({
				url:"<?=site_url("welcome/check_user");?>",
				method:"post",
				data:{
					user_name:user_name
				},
				success:function(res){				
					var obj=JSON.parse(res);
					if(obj.status=="1"){
						alert("Successfully");
						localStorage.setItem("id",obj.data.id);
						localStorage.setItem("user_name",obj.data.user_name);
						checkuser();						
					}
					else{						
						alert(obj.msg);
					}
				},
				error:function(err){
					console.log(err);
				}
			});
		}


		function showresult(){
			$("#r_username").text(localStorage.getItem("user_name"));
			$("#question").hide();
			$("#user").hide();
			$("#result").show();
			resultuser();
		}

		function resultuser(){					
			var id=localStorage.getItem("id");
			if(id > 0){						
				$.ajax({
					url:"<?=site_url("Welcome/resultuser");?>",
					method:"post",
					data:{
						id:id
					},
					success:function(res){
						var obj=JSON.parse(res);
						$("#correctans").text(obj.data.correctans);
						$("#wrongans").text(obj.data.wrongans);
						$("#skipans").text(obj.data.skipans);
					},
					error:function(err){
						console.log(err);
					}
				});
			}
		}

		function logout(){
			localStorage.removeItem("user_name");
			localStorage.removeItem("next");
			localStorage.removeItem("id");
			checkuser();
		}

		function countquestion(){			
			$.ajax({
				url:"<?=site_url("Welcome/allquestions");?>",
				success:function(res){
					var obj=JSON.parse(res);
					$("#allqCount").text(obj.question);
					allquestion=obj.question;
					localStorage.setItem("allquestion",obj.question);					
					checkuser();
				},
				error:function(err){
					console.log(err);
				}
			});
		}

	</script>
</body>
</html>