<?php
/**
 * Created by PhpStorm.
 * User: jsj
 * Date: 15/11/15
 * Time: 16:48
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        html,body{ margin:0;padding:0; font-size: 12px;background-color:"#252525"}
    </style>
</head>
<body>
<iframe id="container" src="<?=$uris[0]?>" style="width: 100%; min-height: 1000px; height: 100%;"  frameborder=0 marginheight=0 marginwidth=0 scrolling=no>

</iframe>
<script>
    var curr_url = 0;
    var uris = <?=json_encode($uris)?>;
    function changeUrl(){

        curr_url ++;
        if(curr_url>=uris.length){
            curr_url = 0;
        }
        document.getElementById("container").src = uris[curr_url];
        setTimeout('changeUrl()',15000)
    }
    setTimeout('changeUrl()',15000)
</script>
</body>
</html>
