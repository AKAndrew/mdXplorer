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
      case 5:
        console.log(`stop`);
        break;
      case 6:
        console.log(`right`);
        break;
      case 8:
        console.log(`down`);
        break;
      default:
        console.log(`stop`);
    }
    //console.log(`Div is ${this.getAttribute("value")}`);
  })
);
