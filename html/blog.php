<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Write your own Blog !</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  <script type="text/javascript" src="../tinymce/js/tinymce/tinymce.js"></script>
</head>
<body>
<?php 

include("../config/connect.php");
include("../html/api.php");
require '../OAuth/google_auth.php';

?>

    <form action="form_handler.php" method="post">

    <div>
    <input type="textarea" name="title" placeholder="add title" cols="80" rows="5" font-size="10px">
    </div>

    <div>



      <textarea cols="80" rows="20" id="articleContent" name="articleContent">
       
        &lt;p&gt;Here's some sample text&lt;/p&gt;
      </textarea>
      <script type="text/javascript">
      tinyMCE.init({
        theme : "modern",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        mode : "exact",
        elements : "articleContent"
      });


</script>
      </script>
      <input type="submit" value="Submit" id="submit_button" />
    </div>

    
  </form>


</body>
</html>