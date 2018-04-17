<h1>Register</h1>
<!-- <form method="post" action="http://localhost/demo_cakephp/users/add"> -->
<?php
    echo $this->Form->create($user,['id'=>'register']);
    echo $this->Form->control('name');
    echo $this->Form->control('email');
    echo $this->Form->control('username');
    echo $this->Form->control('password');
    echo $this->Form->text('check', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->button(__('Save'));
    echo $this->Form->end(); 
?>
<script type="text/javascript">
	$(document).ready(function(){
		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Please check your input."
		);
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
                    required: "Username không được để trống",
                    minlength :"Password phải lớn hơn 6 ký tự",
                    regex:"Password chỉ chứa số hoặc chữ"
                }  
            }
        });
        $('#register').on("register", function(e) {
            var check = true;
            var is_valid_form = $('#register').valid();
            var email = $('#email').val();
            var data = $(this).serialize();
            if (email) {
            	checkEmail(email);
            } else {
                $('#email_error').remove();
            }
            if (is_valid_form && check == true) {
                $.ajax({
                    url: '/demo_cakephp/register',
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        alert(response);
                       if (response==1){
                       		$('#email_error').html("Email da ton tai");
                       }
                    }
                });
            } else {
                return false;
            }
            e.preventDefault();
        });
	});
</script>