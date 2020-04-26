					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('project/edit/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="pname">Project Name: <span class="required">*</span></label>
									<input class="form-control" type="text" name="pname" value="<?php echo $project['project_name'];?>" required />
								</div>
								<div class="form-group">
									<label for="pcode">Project Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="pcode" value="<?php echo $project['project_code'];?>" pattern="\w*" required />
								</div>
								<div class="form-group">
									<label for="desc">Description:</label>
									<textarea class="form-control" name="desc"><?php echo $project['description'];?></textarea>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Submit</button> <a href="<?php echo site_url(array('project','view'));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>