// Create an array to store the trail coordinates
var trail = [];

// Define a function to add a new coordinate to the trail array
function addTrail(x, y) {
  trail.push([x, y]);
}

// Define a function to draw the trail on the canvas
function drawTrail(context) {
  // Loop through the trail coordinates
  for (var i = 0; i < trail.length; i++) {
    var x = trail[i][0];
    var y = trail[i][1];

    // Set the color of the trail segment
    context.strokeStyle = "hsl(" + (i / trail.length * 360) + ", 100%, 50%)";

    // Draw a line segment from the current to the previous coordinate
    if (i > 0) {
      var prev_x = trail[i - 1][0];
      var prev_y = trail[i - 1][1];
      context.beginPath();
      context.moveTo(prev_x, prev_y);
      context.lineTo(x, y);
      context.stroke();
    }
  }
}
