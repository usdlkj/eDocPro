					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open_multipart('file/do_upload', array('class' => 'form-horizontal','role' => 'form'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="userfile">File: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="btn btn-default" type="file" name="userfile" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Upload</button> <a href="<?php echo site_url(array('file','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>