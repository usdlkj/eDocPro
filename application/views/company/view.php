<script>
					$(document).ready( function () {
						var table = $('#data_table').DataTable( {
							"order": [[ 1, "asc" ]],
							"columnDefs": [ 
								{ 
									"targets": 0, 
									"orderable": false,
									"width": 55
								},
								{
									"targets": 4,
									"orderable": false,
									"width": 50
								}
							],
							dom: 
								"<'row'<'col-sm-6'B><'col-sm-6'f>>" + 
								"<'row'<'col-sm-12'tr>>" + 
								"<'row'<'col-sm-3'l><'col-sm-3'i><'col-sm-6'p>>"
							]
						} );
					});
					</script>
					<div class="card">
						<div class="card-header">
							<h5 class="card-title"><?php echo $title;?></h5>
						</div>
						<div class="card-body">
							<a href="<?php echo site_url(array('company','create'));?>" class="btn btn-primary">Create Company</a>
							<div class="table-responsive mt-3">
								<?php if (isset($message)) echo $message;?>
								
								<table id="data_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th scope="col"></th>
										<th scope="col">Company Name</th>
										<th scope="col">Trading Name</th>
										<th scope="col">Company Code</th>
										<th scope="col" class="text-center">Active</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($companies as $company):?><tr>
										<th scope="row" class="text-center">
											<?php $id_hash = $this->hashids->encode($company['id']); if ($company['id'] == '20000001'):?> 
												<button type="button" class="btn btn-xs" disabled>
													<span class="cil-pencil btn-icon"></span>
												</button>
											<?php else:?>
												<a href="<?php echo site_url(array('company','edit',$id_hash));?>" data-toggle="tooltip" title="Edit Company">
													<button type="button" class="btn btn-warning btn-xs">
														<span class="cil-pencil btn-icon"></span>
													</button>
												</a>
											<?php endif;?> 
											<?php if ($company['id'] == '20000001'):?>
												<button type="button" class="btn btn-xs" disabled>
													<span class="cil-trash btn-icon"></span>
												</button>
											<?php else:?>
												<a href="<?php echo site_url(array('company','delete',$id_hash));?>" data-toggle="tooltip" title="Delete Company">
													<button type="button" class="btn btn-danger btn-xs">
														<span class="cil-trash btn-icon">
													</button>
												</a>
											<?php endif;?>
										</th>
										<td><?php echo $company['company_name'];?></td>
										<td><?php echo $company['trading_name'];?></td>
										<td><?php echo strtoupper($company['company_code']);?></td>
										<td class="text-center"><input type="checkbox"<?php if (!$company['deleted_by']):?> checked<?php endif;?> disabled /></td>
									</tr>		
									<?php endforeach;?>
									
								</tbody>
								</table>
							</div>
						</div>
					</div>