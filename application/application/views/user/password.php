					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('user/password/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="password">Password: <span class="required">*</span></label>
									<input class="form-control" type="password" name="password" id="password" placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*()]*$" required data-minlength="8" />
								</div>
								<div class="form-group">
									<label for="cfpassword">Confirm Password: <span class="required">*</span></label>
									<input class="form-control" type="password" name="cfpassword" placeholder="Password" data-match="#password" required />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Set Password</button> <a href="<?php echo site_url(array('user','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>