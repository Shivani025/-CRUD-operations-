<!DOCTYPE html>
<html>
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script></head>
<body>

<!-- Inserting into database -->
<?php  
include('database.php');

$nameErr = $emailErr = "";
$name= $email= $id= "";

if (isset($_POST['submit'])) 
{
  $name =$_POST['name'];
  $email =$_POST['email'];
    // Checking for empty fields 
  if(empty($name)){
    echo "<font color='red'>Name is required.</font><br/>";
  }
  if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "<font color='red'>Invalid email format.</font><br/>";
  }      
else{
      $name = test_input($name);
      $email = test_input($email);
      $sql= "INSERT INTO user(name, email) VALUES ('".$name."','".$email."')";

      if ($conn->query($sql) === TRUE){
      echo "<br>Inserted";
      } 
      else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      }
   }
}
	 
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  return $data;
}
?>


<!-- Form -->
  <h3>Enter the information</h3>     
  <link rel="stylesheet" type="text/css" href="style.css">
  <p><span style="color: blue">* required field</span></p>

<form method="post" action="formd"> 
  Name: <input type="text" name="name">
  <span style="color: blue">*</span>
  <br><br>
  E-mail: <input type="text" name="email">
  <span style="color: blue">* </span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>



<!-- To delete entry from database-->
<?php
if (isset($_GET['id'])) {
  $id=$_GET['id']; 
  $sql = "DELETE FROM user WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully<br><br>";
  }
}
 
 



//display results from database 
echo "Resulted database:"; 
$sql2 = "SELECT * FROM user order by id desc";
$result2 = $conn->query($sql2);


 if ($result2->num_rows > 0){ ?> 
<table>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
    <?php } ?>
    <?php while($row1 = $result2->fetch_assoc()) {?> 
        <tr><td> <?php echo $row1['id'] ?></td>
            <td> <?php echo $row1['name'] ?></td>
            <td> <?php echo $row1['email'] ?></td>
            <td><a href='edit?id=" <?php echo $row1['id'] ?>"'> 
                <button class='btn'>  Edit  </button></a>
                  <br><br> 
                <a href='formd?id="<?php echo $row1["id"] ?>"'>   
                 <button class='btn' id='delete-btn'  data-user_id='<?php echo $row1["id"] ?>'>Delete </button> </a> 
            </td>
        </tr>
      <?php } ?>
</table>
  



<!--Dailogue box -->
<script type="text/javascript">
  $("button#delete-btn").click(function(){
    var  value=$(this).attr('id');
    alert(value);
  var id = $(this).data('user_id');
  var r = confirm('Are you sure to remove this record ?');
  if(r == true){
    $.ajax({
      url: '/formd.php',
      type: 'GET',
      data: {id: id},
      error: function() {
      alert('Something is wrong');},

      success: function(data) {
        $("#"+id).remove();
        alert("Record removed successfully");  }
      });
    }
    else{
      return false;
    }
  });
</script>


</body>
</html>