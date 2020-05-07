/**
* This code is used to manage the interactivity of the map
*/
let mapContainer = document.getElementById("map-container")

let paths = mapContainer.querySelectorAll(".map-image a")
let links = mapContainer.querySelectorAll(".map-list a")

function activeArea(id) {
  document.querySelectorAll(".is-hover").forEach(function(element) {
    element.classList.remove("is-hover")
  })
  if(id !== undefined) {
    document.querySelector("#list-" + id).classList.add("is-hover")
    document.querySelector("#region-" + id).classList.add("is-hover")
  }
}

paths.forEach(function (path) {
  path.addEventListener("mouseenter", function() {
    let id = this.id.replace("region-", "")
    activeArea(id);
  })
})

links.forEach(function (link) {
  link.addEventListener("mouseenter", function() {
    let id = this.id.replace("list-", "")
    activeArea(id);
  })
})

mapContainer.addEventListener("mouseover", function () {
  activeArea();
})