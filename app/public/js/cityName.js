/**
* Fonction qui va récupérer la liste des villes Françaises correspondantes au code postal saisi
*/

function getCityData(zipCode) {
  let url = "https://api-adresse.data.gouv.fr/search/?q="+zipCode+"&type=municipality";

  let xhr = new XMLHttpRequest;
  xhr.open("GET", url);
  xhr.onreadystatechange = () => {
    if(xhr.readyState === 4 && xhr.status === 200){
      let response = JSON.parse(xhr.responseText);
      showCityName(response.features);
    }
  }
  xhr.send(null);
}

function showCityName(cityList) {

  emptySelectElt();

  cityList.forEach(city => {
    const cityName              = city.properties.name;

    let   optionElt             = document.createElement("option");
          optionElt.value       = cityName.toLowerCase();
          optionElt.textContent = cityName;

    select.appendChild(optionElt);
  });
}

function emptySelectElt() {
  while(select.hasChildNodes()) {
    select.removeChild(select.firstChild);
  }
}

let input  = document.getElementById("zip-code");
let select = document.getElementById("city");


input.addEventListener("change", function() {
  if(Number(this.value).toString().length == 5) {
    getCityData(this.value);
  }
  else {
    this.style.borderColor = "red";
    this.value = "";
    this.placeholder = "Veuillez saisir un code postal correct";
  }
})