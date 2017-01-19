        <?php

        include 'config.php';
       
        $result = mysqli_query($db,"INSERT INTO test (name) values ('vishal')");

        if($result)
        {
        	echo "New record has id: " . mysqli_insert_id($db);
        }
        else{
        	echo "problem";	
        }

        ?>