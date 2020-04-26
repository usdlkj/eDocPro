					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
							<?php echo form_open('selectvalue/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="value_code">Selection Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="value_code" placeholder="Selection Code" pattern="\w*" required />
								</div>
								<div class="form-group">
									<label for="value_text">Selection Text: <span class="required">*</span></label>
									<input class="form-control" type="text" name="value_text" placeholder="Selection Text" required />
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('selectvalue','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>