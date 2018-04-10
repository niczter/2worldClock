<!DOCTYPE html>
<html>
<head>
	<title>World Clock</title>
	<style>
		.hrow {
			font-weight:bold;
			color: #C1E97C;
		}
		.hrow td{
			padding-top: 20px;
			width: 140px;
		}
	</style>
</head>
<body>
Philippines</br>
<canvas id="clock" width="300" height="300" style="background-color:white"></canvas>
</br>
<?php
	echo date("H:i e")
?>
</br>
<span id="ny">H:m</span> New York
</br>
<span id="syd">H:m</span> Sydney
</br>

<script>
	var ctx = document.getElementById('clock').getContext("2d");
	var radius = document.getElementById('clock').height / 2;
	ctx.translate(radius, radius);
	radius = radius * 0.90;

	function drawFace(ctx, radius){
		ctx.beginPath();
		ctx.arc(0,0, radius, 0, 2*Math.PI);
		ctx.fillStyle = 'white';
		ctx.fill(); //create body of clock
		ctx.strokeStyle = '#333';
		ctx.lineWidth = radius*0;
		ctx.stroke(); //outer line
		ctx.beginPath();
		ctx.arc(0,0,radius*0.01, 0, 2*Math.PI);
		ctx.fillStyle = '#333';
		ctx.fill(); // color of pivot and content
	}
	function drawNumbers(ctx, radius) {
		var ang;
		var num;
		ctx.font = radius*0.15 + "px arial";
		ctx.textBaseline="middle";
		ctx.textAlign="center";
		for (num = 1; num <13; num++){
			ang = num * Math.PI / 6; //distance between hours
			ctx.rotate(ang);
			ctx.translate(0, -radius*0.85);
			ctx.rotate(-ang);
			ctx.fillText(num.toString(), 0 ,0)
			ctx.rotate(ang);
			ctx.translate(0, radius*0.85);
			ctx.rotate(-ang);
		}
	}
	function drawHand (ctx, pos, length, width){
		ctx.beginPath();
		ctx.lineWidth = width;
		ctx.lineCap = "round";
		ctx.moveTo(0,0);
		ctx.rotate(pos);
		ctx.lineTo(0, -length);
		ctx.stroke();
		ctx.rotate(-pos);
	}
	function drawTime(ctx, radius){
		var now = new Date();
		var hour = now.getHours();
		var minute = now.getMinutes();
		var second = now.getSeconds();
		hour=hour%12 //get remainder of hour to be exact
		hour=(hour*Math.PI/6)+(minute*Math.PI/(6*60))+(second*Math.PI/(360*60)); //6 bc half a clock is 6 hrs //determine where the hour hand is considering the minute and seconds
		drawHand(ctx, hour, radius*0.5, radius*0.07); // call the draw funtion to draw hour and the excess

		minute=(minute*Math.PI/30)+(second*Math.PI/
			(30*60));
		drawHand(ctx, minute, radius*0.8, radius*0.07);

		second=(second*Math.PI/30); //30 bc half a clock is 30 seconds
		drawHand(ctx, second, radius*0.9, radius*0.02);
	}

	function drawClock() {
		drawFace(ctx, radius);
		drawNumbers(ctx, radius);
		drawTime(ctx, radius);
	}


	setInterval(drawClock, 1000)

// This one is in milliseconds, in UTC format
var rawms = new Date().getTime();
// Target timezones are having 5 hours and -3 hours respectively
// Always convert stuff to milliseconds since this is JavaScript
var ny = new Date(rawms + (-4 * 3600 * 1000));//here I effected the gmt difference in ms
var sydney = new Date(rawms + (10 * 3600 * 1000)); //won't use this i'll try another method
var d = new Date();

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

// Display target timezones hours
document.getElementById('ny').innerHTML = addZero(ny.getUTCHours())+":"+addZero(ny.getUTCMinutes());
document.getElementById('syd').innerHTML = addZero(d.getUTCHours()+10)+":"+addZero(d.getUTCMinutes()); // I direct got the  UTCHours and added the gmt difference directly in hours, no need to convert to ms

</script>
</body>
</html>