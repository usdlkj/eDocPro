					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-tile"><?php echo $title;?></h5>
						</div>
						<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
						
						<div class="card-body">
							<?php echo form_open_multipart('file/do_upload', array('class' => 'form-horizontal','role' => 'form'));?>
								<div class="form-group">
									<label for="userfile">File: <span class="required">*</span></label>
									<input class="btn btn-default" type="file" name="userfile" />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Upload</button> 
									<a href="<?php echo site_url(array('file','view'));?>">
										<button type="button" class="btn btn-danger">Cancel</button>
									</a>
								</div>
							</form>
						</div>
					</div>