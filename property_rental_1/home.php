<?php include 'db_connect.php' ?>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['system']['name'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .col {
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
            padding: 0 15px;
            margin-bottom: 30px;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 16px;
        }

        .card-footer {
            padding: 8px 16px;
            background-color: #f8f9fa;
        }

        .summary-icon {
            font-size: 2.5rem;
            color: black;
        }

        .summary-count {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 1rem;
            color: black;
            margin: 0;
        }

        .summary-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .summary-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<div class="container-fluid">
        <div class="row mt-3 ml-3 mr-3">
            <div class="col-md-4 mb-3">
                <div class="card summary-card border-primary">
                    <div class="card-body bg-primary text-white">
                        <span class="float-right summary-icon"><i class="fa fa-home"></i></span>
                        <h4 class="summary-count"><?php echo $conn->query("SELECT * FROM houses")->num_rows ?></h4>
                        <p class="summary-label">Total Properties</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="index.php?page=houses" class="summary-footer-link float-right">View List <span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card summary-card border-warning">
                    <div class="card-body bg-warning text-white">
                        <span class="float-right summary-icon"><i class="fa fa-user-friends"></i></span>
                        <h4 class="summary-count"><?php echo $conn->query("SELECT * FROM tenants where status = 1")->num_rows ?></h4>
                        <p class="summary-label">Total Tenants</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="index.php?page=tenants" class="summary-footer-link float-right">View List <span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card summary-card border-success">
                    <div class="card-body bg-success text-white">
                        <span class="float-right summary-icon"><i class="fa fa-file-invoice"></i></span>
                        <h4 class="summary-count">
                            <?php 
                            $payment = $conn->query("SELECT sum(amount) as paid FROM payments where date(date_created) = '".date('Y-m-d')."' "); 
                            echo $payment->num_rows > 0 ? number_format($payment->fetch_array()['paid'],2) : 0;
                            ?>
                        </h4>
                        <p class="summary-label">Payments This Month</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="index.php?page=invoices" class="summary-footer-link float-right">View Payments <span class="fa fa-angle-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>