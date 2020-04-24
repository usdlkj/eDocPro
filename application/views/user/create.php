<script>
					$(document).ready( function() {
						$(".select2").select2( {
							placeholder: "Select a company",
							allowClear: true
						} );
					} );
					</script>
					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('user/create', array('class' => 'form-horizontal', 'role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="login">Username: <span class="required">*</span></label>
									<input class="form-control" type="text" name="login" placeholder="Username" pattern="\w*" required data-minlength="4" />
								</div>
								<div class="form-group">
									<label for="password">Password: <span class="required">*</span></label>
									<input class="form-control" type="password" name="password" id="password" placeholder="Password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s)[0-9a-zA-Z!@#$%^&*()]*$" required data-minlength="8" />
								</div>
								<div class="form-group">
									<label for="cfpassword">Confirm Password: <span class="required">*</span></label>
									<input class="form-control" type="password" name="cfpassword" placeholder="Password" data-match="#password" required />
								</div>
								<div class="form-group">
									<label for="fname">First Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="fname" placeholder="First Name" required />
								</div>
								<div class="form-group">
									<label for="company">Company: <span class="required">*</span></label>
									<select class="form-control select2" name="company" required>
										<?php foreach($company as $company_item):?><option value="<?php echo $company_item['id'];?>"><?php echo $company_item['company_name'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('user','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>