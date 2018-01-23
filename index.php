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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
	@font-face {
    font-family: Trade Gothic LT Std Extended;
    src: url("assets/TradeGothicLTStd-BoldExt.otf") format("opentype");
}
	body{
	font-family: Trade Gothic LT Std Extended!important;
    line-height: 14px;
    font-size: 14px;
		-webkit-user-select: none;
     -moz-user-select: -moz-none;
      -ms-user-select: none;
          user-select: none;
	}
	h1{
		text-transform: uppercase;
		font-size: 2.5em;
		line-height: 0px;
		-webkit-margin-after: 0.4em;
		-webkit-margin-before: 0.4em;
	}
	a{
		color: black!important;
		text-decoration: none;
	}
	#spotify{
		    position: absolute;
    left: 0;
    top: 0;
	z-index:2;
	}
	#nav{
	    position: absolute;
    top: 0;
    right: 0;
	z-index:2;
    /*width: 100px;
    height: 100px;
    background: red;*/
	text-align:right;
	}
	#img{
		cursor: pointer;
		/*max-width: 100%;
		max-height: 100%;*/
		height: -webkit-fill-available;
	}
	#flex{
	    padding: 0;
		position: absolute;
		margin: 0;
		list-style: none;
		display: flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		height: 100%;
		z-index:1;
	}
	#container2{
		background-repeat:no-repeat;
		background-size:contain;
		position: relative;		
		max-width: 70%;
    	max-height: 70%;
    	width: 70%;
    	height: 70%;
		background-position: 50%;

		/*top: 15%;
		margin: auto;
		border: 1px solid black;*/
	}
	#container2.white{
		background-image: none!important;
	}
	#container2.click{
				cursor: pointer;
	}
	#contactBox{
		width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
	}
	.none
	body{
		margin: 0px;
	}
	#menu span{
		cursor: pointer;
	}
	#menu span:hover, a.list {
		opacity: 0.5;
	}
</style>
<script>
	$(document).ready(function(){
	
	//PHP Array to JS	
	var img = JSON.parse('<?php echo JSON_encode($imgList);?>');

	//On click change img	
	$('#container2').on('click',function(){
		$(this).css('background-image','url(<?php echo $path ?>'+img[Math.floor(Math.random()*img.length)]+')');
	});
		
	//Make image List
	function pad(n) {
		return (n < 10) ? ("0" + n) : n;
	}
		
	for (var num in img){
		var x = '<a href="#" class="list" link="images/'+ img[num] +'">'+ pad(parseInt(num)+1)  +'</a><br>'
		//$(x).append('#categories');
		$('#portfolioBox').append(x);
	}
	
	$('.list').on('click',function(){
		$('#container2').css('background-image','url('+ $(this).attr('link') +')');
	});
		
	//Menu
	$('#portfolio').on('click',function(){
		$('#portfolioBox').show();
		$('#contactBox').hide();
		$('#container2').removeClass('white');
		$('#container2').addClass('click');
	});
		
	$('#works').on('click',function(){
			
	});
		
	$('#contact').on('click',function(){
		$('#portfolioBox').hide();
		$('#contactBox').show();
		$('#container2').addClass('white');
		$('#container2').removeClass('click');
	});
	
	//------------------------------------------------RESIZE
		var windowWidth = $(window).innerWidth();
     	var windowHeight = $(window).innerHeight();
	    $('body').css('width',windowWidth );
        $('body').css('height',windowHeight );
	
        $(window).on('resize',function(){
            console.log('RESIZE WINDOW');
            var OldwindowWidth = windowWidth;
            var OldwindowHeight = windowHeight;
            windowWidth = $(window).innerWidth();
            windowHeight = $(window).innerHeight();
            console.log('width:',windowWidth,'height',windowHeight);
            console.log('OLDwidth:',OldwindowWidth,'OLDheight',OldwindowHeight);
            $('body').css('width',windowWidth );
            $('body').css('height',windowHeight );
        });
});
</script>
</head>

<body>
<iframe src="https://open.spotify.com/embed/user/21pizt3vxnh7w5hylsktuaawi/playlist/0tWi3asASL07tAM57JP6jc" width="300" height="80" frameborder="0" allowtransparency="true" id="spotify"></iframe>
<div id="nav">


	<div id="menu">
	<img src="assets/nome.png"><br>
	<!--h1>PierPaoloMoro</h1-->
	<span id="portfolio">portfolio</span> \ <span id="works">works</span> \ <span id="contact">contact</span>
	
	<div id="portfolioBox"  style="display:none"></div>
<!--a href="#">information</a><br-->
	</div>
</div>
<div id="flex"><div id="container2" class="click" style="background-image: url(<?php echo $path . $img ?>);"><div id="contactBox" style="display:none"><a href="mailto:pierpaolomorouk@gmail.com">pierpaolomorouk@gmail.com</a></div></div>
</div>
</body>
</html>
