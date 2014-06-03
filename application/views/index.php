<div class="container">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title"><strong>Sign in </strong></h3></div>
				<div class="panel-body">
					<form role="form" action="<?php echo ROOT;?>mvc/Customer/Login">
						<div class="form-group">
							<label for="exampleInputEmail1">Username or Email</label>
							<input type="email" name="username" class="form-control" style="border-radius:0px" id="exampleInputEmail1" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password <a href="/sessions/forgot_password">(forgot password)</a></label>
							<input type="password" name="password" class="form-control" style="border-radius:0px" id="exampleInputPassword1" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-sm btn-default">Sign in</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>