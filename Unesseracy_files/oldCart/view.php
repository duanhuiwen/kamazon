<html>
<head>
        <title>View Records</title>
</head>
<body>

<?php
        // connect to the database
		require_once('../common/dbConnect.php');
        
        // number of results to show per page
        $per_page = 5;
        
        //total pages in the database
        $result = mysql_query("SELECT * FROM lab3");
        $total_results = mysql_num_rows($result);
        $total_pages = ceil($total_results / $per_page);

        // check if the 'page' variable is set in the URL (ex: view-paginated.php?page=1)
        if (isset($_GET['page']) && is_numeric($_GET['page']))
        {
                $show_page = $_GET['page'];
                
                // make sure the $show_page value is valid
                if ($show_page > 0 && $show_page <= $total_pages)
                {
                        $start = ($show_page -1) * $per_page;
                        $end = $start + $per_page; 
                }
                else
                {
                        // error - show first set of results
                        $start = 0;
                        $end = $per_page; 
                }               
        }
        else
        {
                // if page isn't set, show first set of results
                $start = 0;
                $end = $per_page; 
        }
        
        // display data in table
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Product</th> <th>Price</th> <th>Description</th> <th>Category</th>  <th></th> <th></th></tr>";

        // loop through results of database query, displaying them in the table 
        for ($i = $start; $i < $end; $i++)
        {
                // make sure that PHP doesn't try to show results that don't exist
                if ($i == $total_results) { break; }
        
                // echo out the contents of each row into a table
                echo "<tr>";
				echo '<td>' . mysql_result($result, $i, 'product') . '</td>';
                echo '<td>' . mysql_result($result, $i, 'price') . '</td>';
                echo '<td>' . mysql_result($result, $i, 'description') . '</td>';
				echo '<td>' . mysql_result($result, $i, 'category') . '</td>';
                echo '<td><a href="edit.php?id=' . mysql_result($result, $i, 'id') . '">Modify</a></td>';
                echo '<td><a href="delete.php?id=' . mysql_result($result, $i, 'id') . '">Delete</a></td>';
                echo "</tr>"; 
        }
        // close table>
        echo "</table>"; 
        
     
        
?>
<p><a href="new.php">Add a new record</a></p>

</body>
</html>