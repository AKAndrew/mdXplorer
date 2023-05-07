"use strict";

function sendAjax(cmd){ // name of function and argument cmd
console.log(`Button ${cmd} clicked!`); // print the value received to console
var xmlhttp = new XMLHttpRequest(); // create an AJAX object
xmlhttp.onreadystatechange = function() { // fired when asking to send data
if (this.readyState == 4 && this.status == 200) // state is done and status is successfull
	console.log(this.responseText); // print to console the PHP response
};
xmlhttp.open("GET", "sendcommand.php?cmd=" + cmd, true); // initializes request
xmlhttp.send(); // send the request to the server
}

document.querySelectorAll(".col").forEach((d) =>
  d.addEventListener("click", function (e) {
    sendAjax(+this.getAttribute("value"));
  })
);

window.addEventListener("keydown", function (event) {
   event.preventDefault();
  switch (event.key) {
    case "ArrowDown":
	  sendAjax('8');
      break;
    case "ArrowUp":
      sendAjax('2');
	  break;
    case "ArrowLeft":
	  sendAjax('4');
      break;
    case "ArrowRight":
	  sendAjax('6');
      break;
	case "Delete":
	  sendAjax('5');
	  break;
    default:
      return; // Quit when this doesn't handle the key event.
  }
}, true);