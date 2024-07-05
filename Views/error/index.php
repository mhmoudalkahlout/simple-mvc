<?php defined('__ROOT__') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Page not found</title>
	</head>
	<body>
		<center>
		    <canvas id="error-canvas" height="550" width="800"></canvas>
		</center>
	</body>
	<script>
		// Get our canvas & context
		var c 	= document.getElementById("error-canvas");
		var ctx = c.getContext("2d");

		/* START CONFIG VARS */

		// What text should display?
		var displayText = '404';
		// What color should the text be?
		var textColor = '#262626';
		// What font should the text use?
		var textStyle = "normal normal bold 200px Arial";
		// How small should the circles get when away from the center?
		var minCircleRadius = 40;
		// How small should the circles get when close to the center?
		var maxCircleRadius = 140;
		// What should the coefficient be for size scaling?
		var circleRadiusProximity = 5;
		// How opaque should the circles get when away from the center?
		var minCircleOpacity = .2;
		// How opaque should the circles get when close to the center?
		var maxCircleOpacity = .9;
		// What should the coefficient be for opacity scaling?
		var circleOpacityProximity = 1000;
		// What colors should be used?  (Adding array pairs here adds beams)
		var colors = {
			'beam1': '255,255,255',
			'beam2': '255,255,255',
			'beam3': '255,255,255',
		}

		/* END CONFIG VARS */

		// An array to hold our beam objects.
		beams = [];
		// Initialize counter
		i = 0;
		// Loop through our colors
		for (color in colors) {
			// For each color, create a beam object.
			beams[color] = {};
			// Set fill color to specified color
			beams[color].fillColor 	= colors[color];
			// Initialize shiftX & moveX to the same random value (in relation to the center point)
			beams[color].shiftX = beams[color].moveX = Math.random() * 2 > 1 ? parseInt(Math.random() * c.width / 2) - minCircleRadius : parseInt(Math.random() * c.width / -2) + minCircleRadius;
			// Initialize shiftY & moveY to the same random value (in relation to the center point)
			beams[color].shiftY = beams[color].moveY = Math.random() * 2 > 1 ? parseInt(Math.random() * c.height / 2) - minCircleRadius : parseInt(Math.random() * c.height / -2) + minCircleRadius;
			// Increment counter
			i++;
		}

		// Start our animation interval
		setInterval(function() {
			// Clear our canvas
			c.width = c.width;

			// Loop through our beam array
			for (beam in beams) {
				// To make things more understandable, let's use "currentBeam"
				currentBeam = beams[beam];
				// If the beams shiftX coord is greater than the moveX coord, decrement shiftX (move it closer)
				if (currentBeam.shiftX > currentBeam.moveX) { currentBeam.shiftX--; }
				// If the beams shiftX coord is less than the moveX coord, increment shiftX (move it closer)
				if (currentBeam.shiftX < currentBeam.moveX) { currentBeam.shiftX++; }
				// If the beams shiftY coord is greater than the moveY coord, decrement shiftY (move it closer)
				if (currentBeam.shiftY > currentBeam.moveY) { currentBeam.shiftY--; }
				// If the beams shiftY coord is less than the moveY coord, increment shiftY (move it closer)
				if (currentBeam.shiftY < currentBeam.moveY) { currentBeam.shiftY++; }
				// If both the shiftX & shiftY are at the moveX & moveY, generate new moveX & moveY to move to.
				if (currentBeam.shiftX == currentBeam.moveX && currentBeam.shiftY == currentBeam.moveY) {
					// Regenerate moveX .. 50% chance of being positive, 50% chance of being negative.
					// Take into account minCircleradius so it doesn't go off the side of the canvas
					currentBeam.moveX 		= Math.random() * 2 > 1 ? parseInt(Math.random() * c.width / 2) - minCircleRadius : parseInt(Math.random() * c.width / -2) + minCircleRadius;
					// Regenerate moveX .. 50% chance of being positive, 50% chance of being negative.
					// Take into account minCircleradius so it doesn't go off the side of the canvas
					currentBeam.moveY 		= Math.random() * 2 > 1 ? parseInt(Math.random() * c.height / 2) - minCircleRadius : parseInt(Math.random() * c.height / -2) + minCircleRadius;
				}
				// Calculate circleRadius by finding how far the shiftX & shiftY are from the center, and dividing by the proximity coefficient.
				circleRadius = maxCircleRadius - ((Math.abs(currentBeam.shiftX) + Math.abs(currentBeam.shiftY)) / circleRadiusProximity);
				// Make sure the circleRadius isn't under the minimum.
				if (circleRadius < minCircleRadius) { circleRadius = minCircleRadius; }

				// Calculate circleOpacity by finding how far the shiftX & shiftY are from the center, and dividing by the proximity coefficient.
				circleOpacity = maxCircleOpacity - ((Math.abs(currentBeam.shiftX) + Math.abs(currentBeam.shiftY)) / circleOpacityProximity);
				// Make sure the circleOpacity isn't under the minimum.
				if (circleOpacity < minCircleOpacity) { circleOpacity = minCircleOpacity; }

				// Set the fill style w/ opacity
				ctx.fillStyle = 'rgba('+currentBeam.fillColor+', '+circleOpacity+')';
				// Begin our drawing path
				ctx.beginPath();
				// Draw our circle
				ctx.arc(c.width/2 + currentBeam.shiftX, c.height/2 + currentBeam.shiftY, circleRadius, 0, 2*Math.PI);
				// Fill our circle
				ctx.fill();
			}

			// Set our text fill style
			ctx.fillStyle = textColor;
			// Set our font
			ctx.font = textStyle;
			// Set our text align as center
			ctx.textAlign = 'center';
			// All our circles are drawn, draw our text over it.
			ctx.fillText(displayText, c.width/2, c.height/2 + 40);
		// Animate at 60 fps
		}, 1000/60);
	</script>
</html>