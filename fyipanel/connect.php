  <?php
try
{
    $con= new PDO('mysql:host=sql101.epizy.com;dbname=epiz_22725205_fyi', 'epiz_22725205', '193e7txCmzpm' );
    $con->exec("set names utf8");
}
catch (Exception $e)
{
        die('Error : ' . $e->getMessage()); 
} 
?>