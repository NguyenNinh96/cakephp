<h1>Register</h1>
<!-- <form method="post" action="http://localhost/demo_cakephp/users/add"> -->
<?php
    echo $this->Form->create($user,['id'=>'register']);
    echo $this->Form->control('name');
    echo $this->Form->control('email');
    echo '<div class="input text required">
    <label for="username">Username</label>
    <input type="text" name="username" required="required" maxlength="50" id="username" class="error">
    <label id="username-error" class="error" for="username"></label>
    <span id="err" style="color:red"></span></div>';
    echo $this->Form->control('password');
    echo $this->Form->button(__('Save',['type'=>'submit']));
    echo $this->Form->end(); 
?>
<script type="text/javascript">
	$.validator.addMethod(
		"regex",
		function(value, element, regexp) {
			var re = new RegExp(regexp);
			return this.optional(element) || re.test(value);
		},
		"Please check your input."
	);
	$(document).ready(function(){
		$("#register").validate({
	            rules:{
	            	name:{
	                    required: true,
	            	},
	            	email:{
	                    required: true,
	                    email:true
	                },
	                username:{
	                    required: true,
	                    minlength: 3 
	                },
	                password:{
	                    required: true,
	                    minlength: 6,
	                    regex:/^[A-Za-z0-9]{6,}$/
	                } 
	            },
	            messages: {
	            	name :{
	                    required: "Name không được để trống"
	                },
	               	email:{
	                    required: "Email không được để trống",
	                    email: "Chưa đúng định dạng email"
	                },
	                username :{
	                    required: "Username không được để trống",
	                    minlength :"Username phải lớn hơn 3 ký tự"
	                },
	                password :{
	                    required: "Password không được để trống",
	                    minlength :"Password phải lớn hơn 6 ký tự",
	                    regex:"Password chỉ chứa số hoặc chữ"
	                }  
	            },
	    });
		$('#username').blur(function() {
			var username = $('#username').val();
			$.ajax({
				url: 'users/checkUser',
				type: 'POST',
				data:{
					username : username,
				},
				success: function (response) {
					
					if(response!=""){
						$('#err').show();
						$('#err').text("Username đã tồn tại");
					}else{
						$('#err').hide();
					}
				}   
			});
		});
	});
</script>