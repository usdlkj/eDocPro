					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('company/create', array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="cname">Company Name: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="cname" placeholder="Company Name" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="tname">Trading Name: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="tname" placeholder="Trading Name" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="ccode">Company Code: <span class="required">*</span></label>
								<div class="col-sm-2">
									<input class="form-control" type="text" name="ccode" placeholder="Company Code" pattern="\w*" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Submit</button> <a href="<?php echo site_url(array('company','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>