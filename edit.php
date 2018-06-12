<?php
// including the database connection file
include_once('database.php');
 
if(isset($_POST['update']))
{      
    $id=$_POST['id'];
    $name= $_POST['name'];
    $email =$_POST['email'];
    
    // checking empty fields
    if(empty($name) || empty($email))
    {            
        if(empty($name))
        {
            echo "<font color='blue'>Name field is empty.</font><br/>";
        }
        
        if(empty($email)) 
        {
            echo "<font color='blue'>Email field is empty.</font><br/>";
        }
     }   
    else
    {              
    
    $sql= "UPDATE user SET name='$name', email='$email' WHERE id='$id'";
    
    $result = $conn->query($sql);

    header('location:formd.php');
   
    }

}
$id= $_GET['id'];

$sql = ("SELECT * FROM user WHERE id=$id");
$result = $conn->query($sql);

while($row=$result->fetch_assoc())
{
    $name= $row['name'];
    $email= $row['email'];
}

?>



<html>
<head>    
    <title>Edit Data</title>
</head>
 
<body>
    <link rel="stylesheet" type="text/css" href="style.css">
    <a href="formd.php">Home</a>
    <br><br>
    <form name="form1" method="post" action="">
        <table border="0">
            <tr> 
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo $name;?>"></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="text" name="email" value="<?php echo $email;?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="<?php echo $_GET['id'];?>" > </td>
                <td><input type="submit" name="update" > </td>
            </tr>
        </table>
    </form>
</body>
</html>