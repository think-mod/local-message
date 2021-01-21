
// Set course color and SVG
function setCourseLayout(color, bgSVG) {

  // Create a SVG Watermark in the background.
  let watermark = document.createElement('div')
  watermark.classList.add("tm-watermark")
  document.getElementById("page-header").firstElementChild.insertBefore(watermark, document.getElementById("page-header").firstElementChild.firstElementChild);

}


