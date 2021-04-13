<?php

    $file = "2003.05446";

    
    $htmlfile = file_get_contents( $file.'.dir/index.html' );
    //chdir( "$file.dir" );
    $htmlfile = str_replace('src="', 'src="'."$file.dir/", $htmlfile); // вставляем $file.dir/ в адреса картинок

    $htmlfile = str_replace('</head>', "<script>intervalID = window.setInterval(func, 10000);
function func(){
  var str = document.getElementById('beginofthedocument').innerHTML;
  var str2 = document.getElementById('endofthedocument').innerHTML;
  if((str.indexOf('<font style=\"vertical-align: inherit;\">') + 1) && (str2.indexOf('<font style=\"vertical-align: inherit;\">') + 1) ){
    //clearInterval(intervalID);
    //alert(str+str2+occur(document.getElementById('bodyofthedocument').innerHTML,'<font style=\"vertical-align: inherit;\">')+' '+occur(document.getElementById('bodyofthedocument').innerHTML,'</span'));
  }
  document.getElementById('test').value=document.getElementById('bodyofthedocument').innerHTML;
}
function occur(str, pattern) {
  var pos = str.indexOf(pattern);
  for (var count = 0; pos != -1; count++)
    pos = str.indexOf(pattern, pos + pattern.length);
  return count;
}
</script>
</head>", $htmlfile); //

$htmlfile = str_replace('<body 
>', '<body>'."<div id='bodyofthedocument'>", $htmlfile); //
$htmlfile = str_replace('</body>', '</div></body>', $htmlfile); //
    echo $htmlfile;
?>
