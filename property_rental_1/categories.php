<?php include('db_connect.php');?>
<head>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Form Panel */
    #manage-category .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #manage-category .card-header {
        background-color: #007bff;
        color: #fff;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }

    #manage-category .card-body {
        padding: 20px;
    }

    #manage-category .card-footer {
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 0 0 10px 10px;
    }

    /* Table Panel */
    .card .card-header {
        background-color: #007bff;
        color: #fff;
        padding: 15px 20px;
    }

    .card .card-body {
        padding: 20px;
    }

    .card .table {
        margin-bottom: 0;
    }

    .card .table th,
    .card .table td {
        vertical-align: middle !important;
        padding: 12px 15px; /* Adjusted padding for table cells */
    }

    .card .table th {
        text-align: center;
    }

    .card .table .btn {
        padding: 8px 12px; /* Adjusted padding for buttons */
        font-size: 14px;
    }

    .card .table .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .card .table .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .card .table .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .card .table .btn-danger:hover {
        background-color: #bd2130;
        border-color: #bd2130;
    }
</style>

</head>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-category">
				<div class="card">
					<div class="card-header">
						    Category Form
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Name</label>
								<input type="text" class="form-control" name="name">
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Category List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Category</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$category = $conn->query("SELECT * FROM categories order by id asc");
								while($row=$category->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['name'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_category" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo $row['name'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_category').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		end_load()
	})
	$('.delete_category').click(function(){
		_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>