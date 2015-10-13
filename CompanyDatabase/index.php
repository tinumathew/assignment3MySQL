<!DOCTYPE html>
<html>
    <head>
        <title>Company Details</title>
        <link rel="stylesheet" type="text/css" href="css/indexStyle.css" />
    </head>
    <body>
        <center><h1><b>COMPANY DETAILS</b></h1></center>
        <form method=GET  id="companyDetails" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate="novalidate">
            <div id="left">
                <select name="choice" id="choice">
                    <option>--select--</option>
                    <option value="newCompanies">New Companies</option>
                    <option value="sortByName">Sort by Name</option>
                </select>
                <input type="submit" name="submit" id="submit" value="Submit"><br><br><br>
                Search by Name: 
                <input type="search" name="searchtxt">
                <input type="submit" name="search" id="search" value="Search"><br><br>                
            </div>
            <div id="right">
                <a href="companyRegistration.php" id="companyreg">Company Registration</a>                
            </div>
            <?php
                $numberOfRecordsPerPage=20;
                //check whether pagination index is set
                if (isset($_GET["page"])) { 
                    $page  = $_GET["page"];                     
                } 
                else { 
                    $page=1;                    
                }
                $startFrom = ($page-1) * $numberOfRecordsPerPage;//set the offset for pagination
                $text="";
                $servername="localhost";
                $username="root";
                $password="kollekatt";
                $dbname="companyDB";
                //create database connection
                $conn=  new mysqli($servername,$username,$password,$dbname);
                //check the connection
                if($conn->connect_error) {
                    die("Connection Failed:".$conn->connect_error);
                }
                //sort according to new companies
                if($_GET["choice"]=="newCompanies") {
                    $sql="SELECT * FROM company ORDER BY formation_on DESC LIMIT $startFrom, $numberOfRecordsPerPage ";
                }
                //sort according to name
                else if($_GET["choice"]=="sortByName") {
                    $sql="SELECT * FROM company ORDER BY name LIMIT $startFrom, $numberOfRecordsPerPage";
                }                 
                //search company by name
                else if(isset($_GET["search"])) {
                    $searchname=$_REQUEST['searchtxt'];                                       
                    $sql="SELECT * FROM company WHERE name='$searchname'";
                }
                //delete an existing company
                else if(isset ($_GET["id"])){ 
                    $id=$_GET["id"];
                    $sql="DELETE FROM company WHERE companyId='$id'";
                    $result=$conn->query($sql);
                    if($result==TRUE) {                                        
                        header('Location: index.php');                                          
                    }
                    else {
                        $text="no records";
                    }
                }
                //print companies according to id
                else {
                    $sql="SELECT * FROM company LIMIT $startFrom, $numberOfRecordsPerPage";
                }                
                $result=$conn->query($sql);
                //display the details
                if($result->num_rows>0) {
                    ?>
                    <table>
                        <tr>
                            <th>Company ID</th>
                            <th>Company Name</th>
                            <th>Formation Date</th>
                            <th>Email</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>ZIP Code</th>
                        </tr>
                        <?php
                            while ($row=$result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $row['companyId']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['formation_on']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['firstName']; ?></td>
                                    <td><?php echo $row['lastName']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['city']; ?></td>
                                    <td><?php echo $row['state']; ?></td>
                                    <td><?php echo $row['zip']; ?></td>
                                    <td><a href="editDetails.php?id=<?php echo $row['companyId'];?>">Edit</a></td>
                                    <td><a href="index.php?id=<?php echo $row['companyId']; ?>" name="delete" >Delete </a></td>                                    
                                </tr>
                                <?php
                            }
                        ?>                                
                    </table>
                    <br>
                    <br>
                    <?php 
                        //pagination
                        $sql1 = "SELECT * FROM company"; 
                        $result= $conn->query($sql1); //run the query
                        $totalRecords = $result->num_rows;  //count number of records
                        $totalPages = ceil($totalRecords / $numberOfRecordsPerPage);//find no.of pages
                        for ($i=1; $i<=$totalPages; $i++) { 
                            ?>
                            <a href='index.php?page=<?php echo $i ?>&choice=<?php echo $_GET["choice"] ?>'><?php echo " | ".$i." |"?></a>  
                            <?php                             
                        } 
                }
                else {
                    echo "No records";
                }   
                $conn->close();
            ?> 
        </form>
    </body>
</html>

