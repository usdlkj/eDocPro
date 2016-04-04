					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('projectuser/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="user">User: <span class="required">*</span></label>
								<div class="col-sm-4">
									<select class="form-control" name="user" placeholder="User" required>
										<?php foreach ($users as $user):?><option value="<?php echo $user['id'];?>"><?php echo $user['first_name'];?></option>
										<?php endforeach;?>
										
									</select>
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Add</button> <a href="<?php echo site_url(array('projectuser','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>