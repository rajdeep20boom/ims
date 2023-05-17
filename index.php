<?php include("include/config.php");
session_start(); 
?>
<?php
if(isset($_SESSION['usr']))
{
    header("location:profile.php");
}
?>
<?php
if(isset($_POST['btn1']))
{
    extract($_POST);
    $q1="SELECT * FROM `user` where `phone`= '$phone'";
    $e1=mysqli_query($conn,$q1);
    if(mysqli_num_rows($e1) ==0)
    {
        function reffer_code($code)
        {
            $data='1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($data),0,$code);
        }
        $refer1=reffer_code(7);
        $q2="INSERT INTO `user`(`name`, `phone`, `password`,`reffer`) VALUES ('$name','$phone','$password','$refer1')";
        $e2=mysqli_query($conn,$q2);

        $q3="INSERT INTO `transaction`(`phone`, `amount`, `details`, `type`, `wallet`) VALUES ('$phone','50','For new user','cr','50')";
        $e3=mysqli_query($conn,$q3);

        $q5="SELECT * FROM `user` where `reffer`= '$refer'";
        $e5=mysqli_query($conn,$q5);

        if(mysqli_num_rows($e5)==0)
        {
            $msg="Registration Succesfully....";
            $color='green';
        }
        else
        {
            $res=mysqli_fetch_row($e5);
            $phone1=$res[2];
            $q6="INSERT INTO `transaction`(`phone`, `amount`, `details`, `type`, `wallet`) VALUES ('$phone1','30','Take 30.Rs for reffer','cr','80')";
            $e6=mysqli_query($conn,$q6);
        }
        $msg="Registration Succesfully....";
        $color='green';
    }
    else
    {
        $msg="phone number is already exist";
        $color='red';
    }
}
else if(isset($_POST['btn2']))
{
    extract($_POST);
    $q4="SELECT * FROM `user` where `phone`= '$phone' and `password`='$password'";
    $e4=mysqli_query($conn,$q4);
    if(mysqli_num_rows($e4))
    {
        $_SESSION['usr']=$phone;
        header("location:profile.php");
    }
    else
    {
        $msg="Invalide phone number and password..";
        $color='red';
    }
}
else
{
    $msg="";
}
?>




<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .card
        {
            box-shadow: 0px 0px 0px grey;
            -webkit-transition:  box-shadow .6s ease-out;
            box-shadow: .8px .9px 3px grey;
        }
        .card:hover
        { 
            box-shadow: 1px 8px 20px grey;
            -webkit-transition:  box-shadow .6s ease-in;
        }
    </style>

  </head>
  <body>
    <!-- Nav tabs -->
      <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <img src="images/logo.jpg" style="height:75px; width:100px; border-radius:40px;">
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button class="btn btn-outline-success my-2 my-sm-0" type="button" data-toggle="modal" data-target="#modelId" style="margin-right:5px;">Sign-up</button>
                <button class="btn btn-outline-success my-2 my-sm-0" type="button"data-toggle="modal" data-target="#modelId1">Login</button>
            </form>
        </div>
      </nav>
      <?php
      if($msg !="")
      {
      ?>
            <div class="alert <?php if($color=='red'){echo "alert-danger";} else{echo "alert-success";} ?> alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>Alert!</strong> <?php echo "$msg";?>
            </div>
        <?php
        }
        ?>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab1Id" role="tabpanel"></div>
        <div class="tab-pane fade" id="tab2Id" role="tabpanel"></div>
        <div class="tab-pane fade" id="tab3Id" role="tabpanel"></div>
        <div class="tab-pane fade" id="tab4Id" role="tabpanel"></div>
        <div class="tab-pane fade" id="tab5Id" role="tabpanel"></div>
    </div>
    <!-- User sign-up Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>    
                <div class="modal-body">
                    <form action="" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text"
                                class="form-control" name="name" id="" aria-describedby="helpId" placeholder="">
                           
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <input type="number"
                                class="form-control" name="phone" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password"
                                class="form-control" name="password" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="">Refer Code</label>
                          <input type="text"
                            class="form-control" name="refer" id="" aria-describedby="helpId" placeholder="have you any refer_code">
                          <small id="helpId" class="form-text text-muted"></small>
                        </div>
                        <button type="submit" name="btn1" class="btn btn-primary">Sign-up</button>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modelId1">You have an account!</button>
                </div>
                
            </div>
        </div>
    </div>
     <!-- Student Log-in Modal -->
    <div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log-In</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                          <label for="">Phone</label>
                          <input type="number"
                            class="form-control" name="phone" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="form-group">
                          <label for="">Password</label>
                          <input type="password"
                            class="form-control" name="password" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <button type="submit" name="btn2" class="btn btn-primary">Log-in</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modelId">New user!</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#navId a').click(e => {
            e.preventDefault();
            $(this).tab('show');
        });
    </script>
      <div id="carouselId" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselId" data-slide-to="0" class="active"></li>
            <li data-target="#carouselId" data-slide-to="1"></li>
            <li data-target="#carouselId" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <img src="images/images.jpg" style="width: 1600px; height:400px" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Title</h3>
                    <p>Description</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/img4.jpg" style="width: 1600px; height:400px" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Title</h3>
                    <p>Description</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/img5.jpg" style="width: 1600px; height:400px" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Title</h3>
                    <p>Description</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselId" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselId" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
      </div>
      <div class="row m-3">
        <div class="col-lg-3">
            <div class="card text-center" style="height:300px;">
                <img class="card-img-top" src="images/bill1.png" style="height:60%; width:100%;" alt="">
                <div class="card-body">
                    <h4 class="card-title">Mobile Recharge</h4>
                    <p class="card-text">Details</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card text-center" style="height:300px;">
                <img class="card-img-top" src="images/bill2.jpg" style="height:60%; width:100%;" alt="">
                <div class="card-body">
                    <h4 class="card-title">Electric Bill</h4>
                    <p class="card-text">Details</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card text-center" style="height:300px;">
                <img class="card-img-top" src="images/bill3.jpg" style="height:60%; width:100%;" alt="">
                <div class="card-body">
                    <h4 class="card-title">Movie Ticket</h4>
                    <p class="card-text">Details</p>
                </div>
            </div>
        </div>
       <div class="col-lg-3">
            <div class="card text-center" style="height:300px;">
                <img class="card-img-top" src="images/bill4.jpg" style="height:60%; width:100%;" alt="">
                <div class="card-body">
                    <h4 class="card-title">Refer & Earn</h4>
                    <p class="card-text">Details</p>
                </div>
            </div>
        </div>
      </div>
      <div class="row bg-dark text-white p-3">
        <div class="col-lg-12">
            Copyright &copy; All Right Reserve
        </div> 
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
 </body>
</html>