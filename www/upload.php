<?php
    include("../config.php");
    include("functions.php");

    $_SESSION['upload']="";
    
    if( is_file($_FILES['file']['tmp_name']) and ($_FILES['file']['size'] > 0) and isset($_POST['rights']) and isset($_POST['edited']) ){
        $id=raw_add($_FILES['file']['tmp_name'],$_FILES['file']['name']);
        if($id){
            $data=raw_getdata($id);
        }
    }
    
    if(!isset($data)){
        echo "File either exist or the cc0 / not modified checkboxes aren't checked";
        exit(0);
    }
    
    // disable submit button if data is missing
    if($data['make']=="" or $data['model']==""){
        $disabled="disabled";
    } else {
        $disabled="";
    }    
    $_SESSION['upload']=$data['checksum'];
?>
<!doctype html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<title>raw.pixls.us</title>
	<link href="css/jquery-ui.css" rel="stylesheet">
    </head>
    <body>
        <h1>Thank you for submitting</h1>
        <div class="ui-widget">
	    <p>If you have access a missing camera, please submit a raw file.</p>
	    <form action="modify.php" method="post">
	        <input type="hidden" id="id" name="id" value="<?php echo $data['id']?>" />
	        <input type="hidden" id="checksum" name="checksum" value="<?php echo $data['checksum']?>" />
                <div>
                    <label for="make">Make:</label>
                    <input class="fc" type="text" id="make" name="make" value="<?php echo $data['make']?>" />
                </div>
                <div>
                    <label for="model">Model:</label>
                    <input class="fc" type="text" id="model" name="model" value="<?php echo $data['model']?>" />
                </div>
                <div>
                    <label for="mode-dummy">Mode:</label>
                    <input class="fc" type="text" id="mode-dummy" name="mode-dummy" value="<?php echo $data['mode']?>" disabled/>
                </div>
                <div>
                    <label for="remark">Comment:</label>
                    <input type="text" id="remark" name="remark" value="<?php echo $data['remark']?>" />
                </div>
                <input type="submit" name="submit" id="submit" value="Update" <?php echo $disabled?> >
            </form>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script>
$(document).ready(function() {
    $(".fc").keyup(function() {
        if ( $("#make").val().length !=0  & $("#model").val().length != 0 ) {
            $("#submit").prop('disabled', false);
        } else {
            $("#submit").prop('disabled', true);
        }
    });
} );
        </script>
    </body>
</html>
