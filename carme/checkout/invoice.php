<?php
session_start();
//Including config file
include "../config_php/configuration.php";
global $connection;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice Page</title>

    <!--Link to CSS-->
    <link rel="stylesheet" href="../css/invoice.css">
</head>


<body>
    <?php
        global $connection;
        $book= $_SESSION["b_id"];
        $sql="SELECT * FROM booking WHERE book_ID= '$book'";
        $result=mysqli_query($connection, $sql);
        $row= mysqli_fetch_array($result, MYSQLI_ASSOC);
        $b_id= $row["book_ID"];
        $m_id= $row["mem_ID"];
        $c_plate= $row["car"];
        $loc= $row["location"];
        $p_u_d= $row["pick_up_date"];
        $d_o_d= $row["drop_off_date"];
        

        $sql2="SELECT * FROM registration WHERE memberID= '$m_id'";
        $result2=mysqli_query($connection, $sql2);
        $row2= mysqli_fetch_array($result2, MYSQLI_ASSOC);
        $m_username = $row2["username"];

        $sql3="SELECT * FROM transaction WHERE booking_ID= '$book'";
        $result3=mysqli_query($connection, $sql3);
        $row3= mysqli_fetch_array($result3, MYSQLI_ASSOC);
        $pay_date = $row3["pay_date"];
        $pay_amount = $row3["pay_amount"];


    ?>
   
   <br><br>

    <div class="invoice-box">
        <h3>Receipt /Invoice</h3>
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="3">
                    <table>
                        <tr>
                            <td>
                                <div class="container-logo">
                                <img src="../images/CarMeLogoFull100px.png">
                                </div>
                            </td>
                            <td style="padding-left: 100px;">
                                Booking number: #<?php echo $b_id . "<br>";?>
                                Member Username: <?php echo $m_username . "<br>";?>
                                Created : <?php date_default_timezone_set("Asia/Kuala_Lumpur");echo date("Y/m/d") . "<br>";?>
                                Time : <?php date_default_timezone_set("Asia/Kuala_Lumpur"); echo date("h:i:sa") . "<br>";?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <!--inner table-->
                    <table>
                        <tr>
                            <td>
                                Car Plate: <?php echo $c_plate . "<br>";?>
                                Pick-up and Drop-off point: <?php echo $loc . "<br>";?>
                                Pick-up date: <?php echo $p_u_d . "<br>";?>
                                Drop-off date: <?php echo $d_o_d . "<br>";?>
                                Payment Date : <?php echo $pay_date . "<br>";?>
                                Payment Amount : RM<?php echo $pay_amount . "<br>";?>
                            </td>
                        </tr>
                    </table>
                    <!--end-->
                </td>
            </tr>
            </table>

        <div class="line" id="line"></div>
        <div class="buttons">
            <p>
                <button id="print-button" onclick = "myPrint()">Print</button>
                <button id="done-button"><a href="../index.php">Done</a></button>
            </p>
        </div>
        
    </div>
    
    <script>
        function myPrint()
        {
            var line = document.getElementById("line");
            var button = document.getElementById("print-button");
            var doneButton = document.getElementById("done-button");


            line.style.visibility = "hidden";
            button.style.visibility = "hidden";
            doneButton.style.visibility = "hidden";
            
            window.print();

            line.style.visibility = "visible";
            button.style.visibility = "visible";
            doneButton.style.visibility = "visible"
        } 
    </script>
       
    <?php
        if (!empty($_SESSION["shopping_cart"])) 
        {
            foreach ($_SESSION["shopping_cart"] as $key => $value)
            {
                if ($_SESSION["carplateCO"] == $key) {
                    unset($_SESSION["shopping_cart"][$key]);
                }
                if(empty($_SESSION["shopping_cart"]))
                {
                    unset($_SESSION["shopping_cart"]);
                }
            }
        }

    unset($_SESSION["voucher"]);
    unset($_SESSION["pay_fullname"]);
    unset($_SESSION["pay_email"]);
    unset($_SESSION["pay_addr"]);
    unset($_SESSION["pay_addr2"]);
    unset($_SESSION["pay_city"]);
    unset($_SESSION["pay_state"]);
    unset($_SESSION["pay_postcode"]);
    unset($_SESSION["carplateCO"]);
    unset($_SESSION["locationCO"]);
    unset($_SESSION["pudCO"]);
    unset($_SESSION["dodCO"]);
    unset($_SESSION["priceCO"]);
    unset($_SESSION["discount"]);
    unset($_SESSION["total_payment"]);
    ?>
</body>

</html>