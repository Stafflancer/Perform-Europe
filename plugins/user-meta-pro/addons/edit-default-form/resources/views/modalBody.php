<?php
namespace UserMeta\EditDefaultForm;

?>

<div>
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="nav-item"><a href="#home" class="nav-link active"
			aria-controls="home" role="tab" data-bs-toggle="tab">Login</a></li>
		<li role="presentation" class="nav-item"><a href="#profile" class="nav-link" aria-controls="profile"
			role="tab" data-bs-toggle="tab">Lost Password</a></li>
		<li role="presentation" class="nav-item"><a href="#messages" class="nav-link" aria-controls="messages"
			role="tab" data-bs-toggle="tab">Reset Password</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="home"><?php (new InputList())->buildInputs('login', $data); ?></div>
		<div role="tabpanel" class="tab-pane" id="profile"><?php (new InputList())->buildInputs('lostpassword', $data); ?></div>
		<div role="tabpanel" class="tab-pane" id="messages"><?php (new InputList())->buildInputs('resetpass', $data); ?></div>
	</div>
</div>
