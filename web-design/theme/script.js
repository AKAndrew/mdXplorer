"use strict";

document.querySelectorAll(".col").forEach((d) =>
  d.addEventListener("click", function (e) {
    switch (+this.getAttribute("value")) {
      case 2:
        console.log(`up`);
        break;
      case 4:
        console.log(`left`);
        break;
      case 6:
        console.log(`right`);
        break;
      case 8:
        console.log(`down`);
        break;
      case 5:
        console.log(`stop`);
		break;
    }
  })
);

window.addEventListener("keydown", function (event) {
  if (event.defaultPrevented) {
    return; // Do nothing if the event was already processed
  }

  switch (event.key) {
    case "ArrowDown":
      console.log(`down`);
      break;
    case "ArrowUp":
      console.log(`up`);
      break;
    case "ArrowLeft":
      console.log(`left`);
      break;
    case "ArrowRight":
      console.log(`right`);
      break;
	case "Delete":
	  console.log(`stop`);
	  break;
    default:
      return; // Quit when this doesn't handle the key event.
  }

  // Cancel the default action to avoid it being handled twice
  event.preventDefault();
}, true);