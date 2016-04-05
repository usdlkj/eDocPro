					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('project/edit/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="pname">Project Name: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="pname" value="<?php echo $project['project_name'];?>" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="pcode">Project Code: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="pcode" value="<?php echo $project['project_code'];?>" pattern="\w*" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="desc">Description:</label>
								<div class="col-sm-4">
									<textarea class="form-control" name="desc"><?php echo $project['description'];?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Submit</button> <a href="<?php echo site_url(array('project','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>