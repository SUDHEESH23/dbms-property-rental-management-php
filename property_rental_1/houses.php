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
    #manage-house .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #manage-house .card-header {
        background-color: #007bff;
        color: #fff;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }

    #manage-house .card-body {
        padding: 20px;
    }

    #manage-house .card-footer {
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
    
    /* Adjustments for p tags inside table cells */
    .card .table td p {
        margin: 0; /* Reset margin */
        padding: 0; /* Reset padding */
        line-height: 1em; /* Adjust line height */
    }
</style>

</head>
<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-house">
				<div class="card">
					<div class="card-header">
						    Property Form
				  	</div>
					<div class="card-body">
							<div class="form-group" id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">House No</label>
								<input type="text" class="form-control" name="house_no" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Category</label>
								<select name="category_id" id="" class="custom-select" required>
									<?php 
									$categories = $conn->query("SELECT * FROM categories order by name asc");
									if($categories->num_rows > 0):
									while($row= $categories->fetch_assoc()) :
									?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
								<?php endwhile; ?>
								<?php else: ?>
									<option selected="" value="" disabled="">Please check the category list.</option>
								<?php endif; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Description</label>
								<textarea name="description" id="" cols="30" rows="4" class="form-control" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control text-right" name="price" step="any" required="">
							</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="reset" > Cancel</button>
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
						<b>Property List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">House</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$house = $conn->query("SELECT h.*,c.name as cname FROM houses h inner join categories c on c.id = h.category_id order by id asc");
								while($row=$house->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><small>House #: <b><?php echo $row['house_no'] ?></b></small></p>
										<p><small>House Type: <b><?php echo $row['cname'] ?></b></small></p>
										<p><small>Description: <b><?php echo $row['description'] ?></b></small></p>
										<p><small>Price: <b><?php echo number_format($row['price'],2) ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_house" type="button" data-id="<?php echo $row['id'] ?>"  data-house_no="<?php echo $row['house_no'] ?>" data-description="<?php echo $row['description'] ?>" data-category_id="<?php echo $row['category_id'] ?>" data-price="<?php echo $row['price'] ?>" >Edit</button>
										<button class="btn btn-sm btn-danger delete_house" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	td p {
		margin: unset;
		padding: unset;
		line-height: 1em;
	}
</style>
<script>
	$('#manage-house').on('reset',function(e){
		$('#msg').html('')
	})
	$('#manage-house').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_house',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">House number already exist.</div>')
					end_load()
				}
			}
		})
	})
	$('.edit_house').click(function(){
		start_load()
		var cat = $('#manage-house')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='house_no']").val($(this).attr('data-house_no'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='category_id']").val($(this).attr('data-category_id'))
		end_load()
	})
	$('.delete_house').click(function(){
		_conf("Are you sure to delete this house?","delete_house",[$(this).attr('data-id')])
	})
	function delete_house($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_house',
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