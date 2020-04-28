					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
						
							<?php echo form_open('mailtype/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="tname">Mail Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="mail_code" placeholder="Mail Code" required />
								</div>
								<div class="form-group">
									<label for="cname">Mail Type: <span class="required">*</span></label>
									<input class="form-control" type="text" name="mail_type" placeholder="Mail Type" required />
								</div>
								
								<div class="form-group">
									<label for="ccode">Is Transmittal:</label>
									<input class="form-control" type="checkbox" name="transmittal" />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('mailtype','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>