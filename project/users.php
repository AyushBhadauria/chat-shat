<?php
 include ('navbar.php');
$fetchdata=new DB_con();
 if(!isset ($_SESSION['email']))
 {
    header('location:login.php');
}
if(isset ($_SESSION['id2']))
{
  unset($_SESSION['id2']);
}
?>

<div class=row style="padding:5px;">
  <?php

$seen=1;
$sql=$fetchdata->fetchusersdata();
while( $row = mysqli_fetch_array($sql)){
    $name=$row['name'];
    $id=$row['id'];
    $email=$row['email'];
    $gender=$row['gender'];
    $image=$row['image'];
?>
<section class="cards">
<div id="image-container">
  <span id="incommon">
<a href="#"><?php echo $gender ?></a>
  </span>
  <img src="<?php echo $image ?>" alt="image">
</div>
<div id="name">
<?php echo $name?>

</div>
<div id="job">
<?php echo $email ?>
</div>
<div class="row">
<div class="col-md-6">
<form method=get action="view-profile.php">
<input hidden type="text" name="id" class="form-control" value= <?php echo $id  ?> >
<div id="connect">
<button type="submit" class="btn btn-success" name="submit">View Profile</button>
</div>
</form>

</div>
<div class="col-md-6">
<form method=get action="chats.php">
<input hidden type="text" name="email" class="form-control" value= <?php echo $email  ?> >
<input hidden type="text" name="seen" class="form-control" value= <?php echo $seen  ?> >
<div id="connect">
<button type="submit" class="btn btn-primary" name="submit">Chat</button>
</div>
</form>

</div>
</div>


</section>
<?php
}
?>
</div>
