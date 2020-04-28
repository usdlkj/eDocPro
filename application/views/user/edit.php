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
							<?php echo form_open('user/edit/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="login">Username: <span class="required">*</span></label>
									<input class="form-control" type="text" name="login" value="<?php echo $user['login'];?>"  pattern="\w*" required data-minlength="4" />
								</div>
								<div class="form-group">
									<label for="fname">First Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="fname" value="<?php echo $user['first_name'];?>" required />
								</div>
								<div class="form-group">
									<label for="company">Company: <span class="required">*</span></label>
									<select class="form-control select2" name="company" required>
										<?php foreach($company as $company_item):?><option value="<?php echo $company_item['id'];?>"<?php if ($company_item['id'] == $user['company_id']):?> selected<?php endif;?>><?php echo $company_item['company_name'];?></option>
										<?php endforeach;?>
									
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Edit</button> <a href="<?php echo site_url(array('user','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>