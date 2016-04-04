					<?php if (isset($message)): echo $message; endif; echo validation_errors();?>
					
					<div class="form-style-2">
						<?php echo form_open('projectfield/create/'.$id_hash, array('class' => 'form-horizontal','role' => 'form', 'data-toggle' => 'validator'));?>
							<div class="form-group">
								<label class="control-label col-sm-2" for="field_code">Field Code: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="field_code" placeholder="Field Code" pattern="\w*" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="field_type">Field Type: <span class="required">*</span></label>
								<div class="col-sm-2">
									<select class="form-control" name="field_type" required>
										<option value="1">Short Text</option>
										<option value="2">Medium Text</option>
										<option value="3">Long Text</option>
										<option value="4">Date</option>
										<option value="5">Single Select</option>
										<option value="6">Multi Select</option>
									</select>
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="field_text">Display Text: <span class="required">*</span></label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="field_text" placeholder="Display Text" required />
								</div>
								<div class="help-block with-errors"></div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="visible">Visible:</label>
								<div class="col-sm-1">
									<input class="form-control" type="checkbox" name="visible" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="visible">Mandatory:</label>
								<div class="col-sm-1">
									<input class="form-control" type="checkbox" name="mandatory" />
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="sequence">Sequence:</label>
								<div class="col-sm-1">
									<select class="form-control" name="sequence">
										<?php for ($i = 0; $i < $fields; $i++):?><option value="<?php echo $i+1;?>"><?php echo $i+1;?></option>
										<?php endfor;?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-primary">Create</button> <a href="<?php echo site_url(array('projectfield','view',$id_hash));?>"><button type="button" class="btn btn-danger">Cancel</button></a>
								</div>
							</div>
						</form>
					</div>