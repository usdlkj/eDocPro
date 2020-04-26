					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="card w-50">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							
							<?php echo form_open('projectfield/edit/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
								<input type="hidden" name="hidden_field_code" value="<?php echo $field['field_code'];?>" />
								<input type="hidden" name="hidden_field_type" value="<?php echo $field['field_type'];?>" />
								<div class="form-group">
									<label for="field_code">Field Code:</label>
									<input class="form-control" type="text" name="field_code" value="<?php echo $field['field_code'];?>" disabled />
								</div>
								<div class="form-group">
									<label for="field_type">Field Type:</label>
									<select class="form-control" name="field_type" disabled>
										<option value="1"<?php if ($field['field_type'] == 1) echo ' selected';?>>Short Text</option>
										<option value="2"<?php if ($field['field_type'] == 2) echo ' selected';?>>Medium Text</option>
										<option value="3"<?php if ($field['field_type'] == 3) echo ' selected';?>>Long Text</option>
										<option value="4"<?php if ($field['field_type'] == 4) echo ' selected';?>>Date</option>
										<option value="5"<?php if ($field['field_type'] == 5) echo ' selected';?>>Single Select</option>
										<option value="6"<?php if ($field['field_type'] == 6) echo ' selected';?>>Multi Select</option>
									</select>
								</div>
								<div class="form-group">
									<label for="field_text">Display Text: <span class="required">*</span></label>
									<input class="form-control" type="text" name="field_text" value="<?php echo $field['field_text'];?>" required />
								</div>
								<div class="form-group">
									<label for="visible">Visible:</label>
									<input class="form-control" type="checkbox" name="visible"<?php if ($field['visible']) echo ' checked';?> />
								</div>
								<div class="form-group">
									<label for="visible">Mandatory:</label>
									<input class="form-control" type="checkbox" name="mandatory"<?php if ($field['mandatory']) echo ' checked';?> />
								</div>
								<div class="form-group">
									<label for="sequence">Sequence:</label>
									<select class="form-control" name="sequence">
										<?php for ($i = 0; $i < $fields; $i++):?><option value="<?php echo $i+1;?>"<?php if ($field['sequence'] == $i+1) echo ' selected';?>><?php echo $i+1;?></option>
										<?php endfor;?>
									</select>
								</div>
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Edit</button> <a href="<?php echo site_url(array('projectfield','view',$project_id));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</form>
						</div>
					</div>