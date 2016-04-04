					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('project/create', array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="pname">Project Name: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="pname" placeholder="Project Name" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="pcode">Project Code: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="pcode" placeholder="Project Code" pattern="\w*" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="desc">Description:</label>
								<div class="col-sm-4">
									<textarea class="form-control" name="desc" placeholder="Description"></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('project','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>