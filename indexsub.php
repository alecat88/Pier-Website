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

//CATEGORIE
$subs = array();
$results = scandir($path);

foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($path . '/' . $result)) {
      $subs[] = $result;
    }
}

// Obtain list of images from directory 
$imgList = getImagesFromDir($root . $path);
$img = getRandomFromArray($imgList);




?> 
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PierPaolo Moro</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
	@font-face {
    font-family: Trade Gothic LT Std Extended;
    src: url("assets/TradeGothicLTStd-BoldExt.otf") format("opentype");
		font-weight: bold;
}
	@font-face {
    font-family: Trade Gothic LT Std Extended;
    /*src: url("assets/TradeGothicLTStd-BoldExt.otf") format("opentype");*/
		src: url("assets/TradeGothicLTStd-Light.otf") format("opentype");
		font-weight: lighter;
}
	@font-face {
    font-family: Trade Gothic LT Std Extended;
    /*src: url("assets/TradeGothicLTStd-BoldExt.otf") format("opentype");*/
		src: url("assets/TradeGothicLTStd.otf") format("opentype");
		font-weight: normal;
}
	
	
	body{
	font-family: Trade Gothic LT Std Extended!important;
    line-height: 14px;
    font-size: 12px;
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
		/*background-size:contain;*/
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
	#contactBox, #infoBox{
		width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
		text-align: center;
	}
	body{
		margin: 0px;
	}
	#menu span{
		cursor: pointer;
	}
	#menu span:hover, a.list:hover {
		opacity: 0.5;
	}
	#menu span.active{
		text-decoration: underline;
	}
	@media screen and (max-width: 2560px){
		#portfolioBox{
			margin-top:3px;
		}
	}
</style>
<script>
	$(document).ready(function(){
	var subs = JSON.parse('<?php echo JSON_encode($subs);?>');
	//PHP Array to JS	
	var img = JSON.parse('<?php echo JSON_encode($imgList);?>');

	//On click change img	
		
	function changeImg(number){
		if (!number){var number = Math.floor(Math.random()*img.length);
		}
		var imgURL = img[number];
		var path = "<?php echo $path ?>";
		//var imgURL = img[Math.floor(Math.random()*img.length)];
		var hidden = '<img style="display:none" id="imagetogetsize" src="'+path+imgURL+'">';
		$('#hidden').html(hidden);
		image = document.getElementById('imagetogetsize');
		//$('#imagetogetsize').load(function(){console.log('cia')});
		$('#imagetogetsize').on('load',function(){
			var width = image.naturalWidth;
			var height = image.naturalHeight;

			var box = $('#container2');
			var boxwidth = box.width();
			var boxheight = box.height();
			console.log(width,height,boxwidth,boxheight);
			if (width < boxwidth && height < boxheight){
				box.css('background-size','auto');
			} else {
				box.css('background-size','contain');
			}
			box.css('background-image','url('+ path +imgURL+')');
		});
		
		 return number;
	}	
	changeImg();
	$('#container2').on('click',function(){
		//$(this).css('background-image','url(<?php echo $path ?>'+img[Math.floor(Math.random()*img.length)]+')');
	var listNum = changeImg();
		$('a.list').css('text-decoration','none');
		$('a.list').eq(listNum).css('text-decoration','underline');
		
	});
		
	//Make image List and Menu
	function pad(n) {
		return (n < 10) ? ("0" + n) : n;
	}
		
	for (var num in img){
		var x = '<a href="#" class="list" number="'+(num) +'" link="images/'+ img[num] +'">'+ pad(parseInt(num)+1)  +'</a><br>'
		//$(x).append('#categories');
		$('#portfolioNum').append(x);
	}
	
	//Subcategories
	if (0 < subs.length){
		for (var sub in subs){
			var div= '<div class="sub" id="'+subs[sub]+'">'+subs[sub]+'<div class="num"></div></div>';
			$(div).insertBefore('#portfolioNum');
		}
		$('.sub').each(function(){
			//add numbers;
		});
	}
	//Menu Actiov
	$('.list').on('click',function(){
		$('.list').css('text-decoration','none');
		
		changeImg($(this).attr('number'));
		//$('#container2').css('background-image','url('+ $(this).attr('link') +')');
		$(this).css('text-decoration','underline');
	});
		
	$('#portfolio').on('click',function(){
		$('#info.active').removeClass('active');
		$('#contact.active').removeClass('active');
		if ($(this).hasClass('active')){$('#portfolioBox').hide(); $(this).removeClass('active')}
		else {$('#portfolioBox').show(); $(this).addClass('active');};
		$('#contactBox').hide();
		$('#infoBox').hide();
		$('#container2').removeClass('white');
		$('#container2').addClass('click');
		
		
	});
		
	$('#info').on('click',function(){
		$('#portfolioBox').hide();
		$('#contactBox').hide();
		$('#infoBox').show();
		$('#container2').addClass('white');
		$('#container2').removeClass('click');
		$('#menu span.active').removeClass('active');
		$('#info').addClass('active');
	});
		
	$('#contact').on('click',function(){
		$('#portfolioBox').hide();
		$('#contactBox').show();
		$('#infoBox').hide();
		$('#container2').addClass('white');
		$('#container2').removeClass('click');
		$('#menu span.active').removeClass('active');
		$('#contact').addClass('active');
	});
	
	$('#logo').on('click',function(){
		$('#portfolioBox').hide();
		$('#contactBox').hide();
		$('#infoBox').hide();
		$('#container2').removeClass('white');
		$('#container2').addClass('click');
		$('#menu span.active').removeClass('active');
		//$('#container2').css('background-image','url(<?php echo $path ?>'+img[Math.floor(Math.random()*img.length)]+')');
		changeImg();
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
<!--iframe src="https://open.spotify.com/embed/user/21pizt3vxnh7w5hylsktuaawi/playlist/0tWi3asASL07tAM57JP6jc&theme=white&" width="300" height="80" frameborder="0" allowtransparency="true" id="spotify"></iframe-->
<!--iframe src="https://open.spotify.com/embed?uri=spotify%3Auser%3A21pizt3vxnh7w5hylsktuaawi%3APlaylist%3A0tWi3asASL07tAM57JP6jc&theme=white" width="300" height="80" frameborder="0" allowtransparency="true"></iframe-->
<iframe src="https://open.spotify.com/embed?uri=spotify%3Auser%3A21pizt3vxnh7w5hylsktuaawi%3Aplaylist%3A0tWi3asASL07tAM57JP6jc&theme=white" width="300" height="80" frameborder="0" allowtransparency="true"  id="spotify"></iframe>
<div id="nav">


	<div id="menu">
	<img id="logo" src="assets/nome.png" style="max-width: 27.5em; cursor: pointer"><br>
	<!--h1>PierPaoloMoro</h1-->
	<span id="portfolio">portfolio</span> \ <span id="info">info</span> \ <span id="contact">contact</span>
	
	<div id="portfolioBox"  style="display:none">
		<div id="portfolioNum"></div>
	</div>
<!--a href="#">information</a><br-->
	</div>
</div>
<div id="flex"><div id="container2" class="click"><div id="contactBox" style="display:none"><a href="mailto:pierpaolomorouk@gmail.com">pierpaolomorouk@gmail.com</a></div><div id="infoBox" style="display: none"><!--I’m Pier.<br>
I live in London.<br>
I love Violence.<br>
Normal Life exite me.<br>
Nothing is more Vicious<br>
than Reality-->
1994 Born.<br>
2013 IUAV university of Design.<br>
2016 Internship at Pitis (Paris) Erasmus+ Winner.<br>
2016 BA Degree in Graphic and Industrial Design.<br>
2016 Moved to London.<br>
2016 Internship at Guru Graphics Limited (London) Erasmus+ Winner.<br>
2017 Graphic Designer at Guru Graphics Limited (Full Time).<br>
2017 Visual Designer at GVC Holding (London).
</div></div>
</div>
	
</body>
<div style="display:none; opacity: 0; width: 0px; height: 0px" id="hidden"></div>
</html>
