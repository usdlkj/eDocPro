					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<?php echo form_open('projectfield/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<div class="form-group">
									<label for="field_code">Field Code: <span class="required">*</span></label>
									<input class="form-control" type="text" name="field_code" placeholder="Field Code" pattern="\w*" required />
								</div>
								<div class="form-group">
									<label for="field_type">Field Type: <span class="required">*</span></label>
									<select class="form-control" name="field_type" required>
										<option value="1">Short Text</option>
										<option value="2">Medium Text</option>
										<option value="3">Long Text</option>
										<option value="4">Date</option>
										<option value="5">Single Select</option>
										<option value="6">Multi Select</option>
									</select>
								</div>
								<div class="form-group">
									<label for="field_text">Display Text: <span class="required">*</span></label>
									<input class="form-control" type="text" name="field_text" placeholder="Display Text" required />
								</div>
								<div class="form-group">
									<label for="visible">Visible:</label>
									<input class="form-control" type="checkbox" name="visible" />
								</div>
								<div class="form-group">
									<label for="visible">Mandatory:</label>
									<input class="form-control" type="checkbox" name="mandatory" />
								</div>
								<div class="form-group">
									<label for="sequence">Sequence:</label>
									<select class="form-control" name="sequence">
										<?php for ($i = 0; $i < $fields; $i++):?><option value="<?php echo $i+1;?>"><?php echo $i+1;?></option>
										<?php endfor;?>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('projectfield','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>