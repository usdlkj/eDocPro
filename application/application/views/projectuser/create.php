					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
							<?php echo form_open('projectuser/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="user">User: <span class="required">*</span></label>
									<select class="form-control" name="user" placeholder="User" required>
										<?php foreach ($users as $user):?><option value="<?php echo $user['id'];?>"><?php echo $user['first_name'];?></option>
										<?php endforeach;?>
										
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Add</button> <a href="<?php echo site_url(array('projectuser','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>