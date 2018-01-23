<?php

/////////////////////////////////////////////////////////////////////
// This is the only portion of the code you may need to change.
// Indicate the location of your images 
$root = '';
// use if specifying path from root
//$root = $_SERVER['DOCUMENT_ROOT'];

$path = 'images/';

// End of user modified section 
/////////////////////////////////////////////////////////////////////
 
function getImagesFromDir($path) {
    $images = array();
    if ( $img_dir = @opendir($path) ) {
        while ( false !== ($img_file = readdir($img_dir)) ) {
            // checks for gif, jpg, png
            if ( preg_match("/(\.gif|\.jpg|\.png)$/", $img_file) ) {
                $images[] = $img_file;
            }
        }
        closedir($img_dir);
    }
    return $images;
}

function getRandomFromArray($ar) {
    mt_srand( (double)microtime() * 1000000 ); // php 4.2+ not needed
    $num = array_rand($ar);
    return $ar[$num];
}



// Obtain list of images from directory 
$imgList = getImagesFromDir($root . $path);

$img = getRandomFromArray($imgList);


?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Demo</title>
<link href="css.css" rel="stylesheet">
<script src="jquery-3.2.1.min.js"></script>
<script>
var js_arr2 = JSON.parse('<?php echo JSON_encode($imgList);?>');
var hidden = 'images/' + js_arr2[Math.floor(Math.random()*js_arr2.length)];
	$('#hidden').attr('src',hidden);	
	function refresh(){
		$('#img').attr('src',hidden);
		hidden = 'images/' + js_arr2[Math.floor(Math.random()*js_arr2.length)];
		$('#hidden').attr('src',hidden);
		if ($('#spotify').position().top == $('#img').position().top) {$('#spotify').css('float','right');$('#spotify').css('margin-left','64px');}
		else {$('#spotify').css('float','left');$('#spotify').css('margin-left','0px');}
	}
	function info(){
		$('#info').show();
		$('#hidden').hide();
		$('#img').hide();
		$('#onAbout').show();
		$('#onHome').hide();
	}
	function home(){
		$('#info').hide();
		$('#hidden').show();
		$('#img').show();
		$('#onAbout').hide();
		$('#onHome').show();
	}
$(document).ready(function(){
	
	
	function reSize(){
		
	}
	reSize();
	$('#img').on('click',function(){
		refresh();
	})
	
	function onWindowResize(){
		windowHeight= $(window).height();
		windowWidth= $(window).width();
		menuHeight = $('#menu').outerHeight();
		
		height = windowHeight - menuHeight - 100;
		width = windowWidth - 50;	
		console.log('windowHeight',windowHeight);
		console.log('menuHeight',menuHeight);
		console.log('height',height);
		console.log('windowWidth',windowWidth);

		$('#container').css('width',width);
		$('#container').css('height',height);
		
		if ($('#spotify').position().top == $('#img').position().top) {$('#spotify').css('float','right');$('#spotify').css('margin-left','64px');}
		else {$('#spotify').css('float','left');$('#spotify').css('margin-left','0px');}
	}
	onWindowResize();
	
	$( window ).resize(function(){
		onWindowResize()
	});
});

	</script>
</head>
<body>
<div id="menu">
<img id="hidden" src="" alt="" style="visibility: hidden; opactity: 0; position: absolute; z-index: 0;"/>
<p id="onAbout" style="display: none;"><a href="#" onClick="home()">Pier Paolo Moro</a></p>
<p id="onHome">Pier Paolo Moro</p>
<p><a href="mailto:pierpaolomorouk@gmail.com">pierpaolomorouk@gmail.com</a></p>
<p><a href="#" onClick="info()">Information</a></p>
<div id="info" style="display:none">
<ul>
<li>2016 intern at Pitis In Paris</li>
<li>2016 BA Degree at IUAV</li>
<li>2016 Graphic Designer at Guru Graphics</li>
<li>2017 Graphic Designer at GVC Holding</li>
</ul>
</div>
</div>



<!-- image displays here -->
<div id="container"><img id="img" src="<?php echo $path . $img ?>"><iframe id="spotify" src="https://open.spotify.com/embed/user/21pizt3vxnh7w5hylsktuaawi/playlist/0tWi3asASL07tAM57JP6jc?view=coverart" width="300" height="380" frameborder="0" allowtransparency="true"></iframe></div>



<p>&nbsp;</p>



</body>
</html>