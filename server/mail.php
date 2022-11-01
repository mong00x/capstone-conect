
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    
        <title>Admin site for emailjs management </title>
    </head>
    <body>
        <h2>Email js connecting variables</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                    <th >serviceID</th>
                    <th >templateID</th>
                    <th >publicKey</th>
                    </tr>
                </thead>
                <tbody>
                
        <?php 
            include_once 'includes.php';
            $query = "SELECT * FROM emailjs";
            connectDB();
            $result = mysqli_query($_SESSION['db'],$query) or die("<p><b>A fatal MySQL error occured</b>.\n<br />Query: " . $query . "<br />\nError: (" . mysqli_errno($_SESSION['db']) . ") " . mysqli_error($_SESSION['db']) . "</p>");
            closeDB();
            if(mysqli_num_rows($result)<1){
              // no result
              echo "no results";
            }else{
                $a=0;
                while($row = mysqli_fetch_assoc($result))
                { 
        ?>  
                <tr>
                
                <td><?php echo $row['serviceID'];?></td>
                <td><?php echo $row['templateID'];?></td>
                <td><?php echo $row['publicKey'];?></td>	
                <td><a class= "btn btn-secondary" href="http://localhost/add.html">Use new</a></td>

                </tr>		  							  
        <?php		
                $a++;											  
                }
            
            }
        ?>		  
                </tbody>
            </table>
        </div>
    </body>
</html>
        
                
        


