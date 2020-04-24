<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('project/create', array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="pname">Project Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="pname" placeholder="Project Name" required />
								</div>
								<div class="form-group">
									<label or="pcode">Project Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="pcode" placeholder="Project Code" pattern="\w*" required />
								</div>
								<div class="form-group">
									<label for="desc">Description:</label>
									<textarea class="form-control" name="desc" placeholder="Description"></textarea>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('project','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>