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
$path2 = 'images/' . $name[0];
$results = scandir($path2);

foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($path2 . '/' . $result)) {
        //code to use if directory
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
	#large-header,#demo-canvas{height: 100%!important; width: 100%!important}
	@media screen and (max-width: 2560px){
		#portfolioBox{
			margin-top:3px;
		}
	}
</style>
<script>
	$(document).ready(function(){
	
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
		
	//Make image List
	function pad(n) {
		return (n < 10) ? ("0" + n) : n;
	}
		
	for (var num in img){
		var x = '<a href="#" class="list" number="'+(num) +'" link="images/'+ img[num] +'">'+ pad(parseInt(num)+1)  +'</a><br>'
		//$(x).append('#categories');
		$('#portfolioBox').append(x);
	}
	
	$('.list').on('click',function(){
		$('.list').css('text-decoration','none');
		
		changeImg($(this).attr('number'));
		//$('#container2').css('background-image','url('+ $(this).attr('link') +')');
		$(this).css('text-decoration','underline');
	});
		
	//Menu
	$('#portfolio').on('click',function(){
		if ($(this).hasClass('active')){$('#portfolioBox').hide(); $(this).removeClass('active')}
		else {$('#portfolioBox').show()};
		$('#contactBox').hide();
		$('#infoBox').hide();
		$('#container2').removeClass('white');
		$('#container2').addClass('click');
		$('#menu span.active').removeClass('active');
		$('#portfolio').addClass('active');
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
<div class="container demo-1" style="position: absolute; top: 0;left: 0;">
	<div class="content">
     <div id="large-header" class="large-header">
		    <canvas id="demo-canvas"></canvas>
     </div>
  </div>
</div>
<!--iframe src="https://open.spotify.com/embed/user/21pizt3vxnh7w5hylsktuaawi/playlist/0tWi3asASL07tAM57JP6jc&theme=white&" width="300" height="80" frameborder="0" allowtransparency="true" id="spotify"></iframe-->
<!--iframe src="https://open.spotify.com/embed?uri=spotify%3Auser%3A21pizt3vxnh7w5hylsktuaawi%3APlaylist%3A0tWi3asASL07tAM57JP6jc&theme=white" width="300" height="80" frameborder="0" allowtransparency="true"></iframe-->
<iframe src="https://open.spotify.com/embed?uri=spotify%3Auser%3A21pizt3vxnh7w5hylsktuaawi%3Aplaylist%3A0tWi3asASL07tAM57JP6jc&theme=white" width="300" height="80" frameborder="0" allowtransparency="true"  id="spotify"></iframe>
<div id="nav">


	<div id="menu">
	<img id="logo" src="assets/nome.png" style="max-width: 27.5em; cursor: pointer"><br>
	<!--h1>PierPaoloMoro</h1-->
	<span id="portfolio">portfolio</span> \ <span id="info">info</span> \ <span id="contact">contact</span>
	
	<div id="portfolioBox"  style="display:none"></div>
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
<div style="display:none; opacity: 0; width: 0px; height: 0px" id="hidden"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/TweenLite.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.13.2/easing/EasePack.min.js"></script>
<script>
	(function() {

    var width, height, largeHeader, canvas, ctx, points, target, animateHeader = true;

    // Main
    initHeader();
    initAnimation();
    addListeners();

    function initHeader() {
        width = window.innerWidth;
        height = window.innerHeight;
        target = {x: width/2, y: height/2};

        largeHeader = document.getElementById('large-header');
        largeHeader.style.height = height+'px';

        canvas = document.getElementById('demo-canvas');
        canvas.width = width;
        canvas.height = height;
        ctx = canvas.getContext('2d');

        // create points
        points = [];
        for(var x = 0; x < width; x = x + width/20) {
            for(var y = 0; y < height; y = y + height/20) {
                var px = x + Math.random()*width/20;
                var py = y + Math.random()*height/20;
                var p = {x: px, originX: px, y: py, originY: py };
                points.push(p);
            }
        }

        // for each point find the 5 closest points
        for(var i = 0; i < points.length; i++) {
            var closest = [];
            var p1 = points[i];
            for(var j = 0; j < points.length; j++) {
                var p2 = points[j]
                if(!(p1 == p2)) {
                    var placed = false;
                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(closest[k] == undefined) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }

                    for(var k = 0; k < 5; k++) {
                        if(!placed) {
                            if(getDistance(p1, p2) < getDistance(p1, closest[k])) {
                                closest[k] = p2;
                                placed = true;
                            }
                        }
                    }
                }
            }
            p1.closest = closest;
        }

        // assign a circle to each point
        for(var i in points) {
            var c = new Circle(points[i], 2+Math.random()*2, 'rgba(255,255,255,0.3)');
            points[i].circle = c;
        }
    }

    // Event handling
    function addListeners() {
        if(!('ontouchstart' in window)) {
            window.addEventListener('mousemove', mouseMove);
        }
        window.addEventListener('scroll', scrollCheck);
        window.addEventListener('resize', resize);
    }

    function mouseMove(e) {
        var posx = posy = 0;
        if (e.pageX || e.pageY) {
            posx = e.pageX;
            posy = e.pageY;
        }
        else if (e.clientX || e.clientY)    {
            posx = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
            posy = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
        }
        target.x = posx;
        target.y = posy;
    }

    function scrollCheck() {
        if(document.body.scrollTop > height) animateHeader = false;
        else animateHeader = true;
    }

    function resize() {
        width = window.innerWidth;
        height = window.innerHeight;
        largeHeader.style.height = height+'px';
        canvas.width = width;
        canvas.height = height;
    }

    // animation
    function initAnimation() {
        animate();
        for(var i in points) {
            shiftPoint(points[i]);
        }
    }

    function animate() {
        if(animateHeader) {
            ctx.clearRect(0,0,width,height);
            for(var i in points) {
                // detect points in range
                if(Math.abs(getDistance(target, points[i])) < 4000) {
                    points[i].active = 0.3;
                    points[i].circle.active = 0.6;
                } else if(Math.abs(getDistance(target, points[i])) < 20000) {
                    points[i].active = 0.1;
                    points[i].circle.active = 0.3;
                } else if(Math.abs(getDistance(target, points[i])) < 40000) {
                    points[i].active = 0.02;
                    points[i].circle.active = 0.1;
                } else {
                    points[i].active = 0;
                    points[i].circle.active = 0;
                }

                drawLines(points[i]);
                points[i].circle.draw();
            }
        }
        requestAnimationFrame(animate);
    }

    function shiftPoint(p) {
        TweenLite.to(p, 1+1*Math.random(), {x:p.originX-50+Math.random()*100,
            y: p.originY-50+Math.random()*100, ease:Circ.easeInOut,
            onComplete: function() {
                shiftPoint(p);
            }});
    }

    // Canvas manipulation
    function drawLines(p) {
        if(!p.active) return;
        for(var i in p.closest) {
            ctx.beginPath();
            ctx.moveTo(p.x, p.y);
            ctx.lineTo(p.closest[i].x, p.closest[i].y);
            ctx.strokeStyle = 'rgba(185, 185, 185,'+ p.active+')';
            ctx.stroke();
        }
    }

    function Circle(pos,rad,color) {
        var _this = this;

        // constructor
        (function() {
            _this.pos = pos || null;
            _this.radius = rad || null;
            _this.color = color || null;
        })();

        this.draw = function() {
            if(!_this.active) return;
            ctx.beginPath();
            ctx.arc(_this.pos.x, _this.pos.y, _this.radius, 0, 2 * Math.PI, false);
            ctx.fillStyle = 'rgba(185, 185, 185,'+ _this.active+')';
            ctx.fill();
        };
    }

    // Util
    function getDistance(p1, p2) {
        return Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2);
    }
    
})();</script>		
</body>

</html>
