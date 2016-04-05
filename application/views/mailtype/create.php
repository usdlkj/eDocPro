					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('mailtype/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cname">Mail Type: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="mail_type" placeholder="Mail Type" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="tname">Mail Code: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="mail_code" placeholder="Mail Code" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="ccode">Is Transmittal:</label>
								<div class="col-sm-1">
									<input class="form-control" type="checkbox" name="transmittal" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('mailtype','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>