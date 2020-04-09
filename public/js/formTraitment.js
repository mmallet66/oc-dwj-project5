function ajaxGet(url, callback) {
  const xhr = new XMLHttpRequest;
  xhr.open("GET", url);

  xhr.onreadystatechange = () => {
    if(xhr.readyState === 4 && xhr.status === 200) {
      callback(JSON.parse(xhr.responseText));
    }
  }

  xhr.send(null);
}

function getCityData(zipCode) {
  if(zipCode != "") {
    const url = "https://geo.api.gouv.fr/communes?codePostal="+zipCode;

    ajaxGet(url, updateCityList);
  }
  else {
    updateCityList([]);
  }
}

function updateCityList(cityList) {
  while(cityListContainer.hasChildNodes()) {
    cityListContainer.removeChild(cityListContainer.firstChild);
  }

  if(cityList.length != 0) {
    cityList.forEach(city => {
      createCityItem(city);
    });
  }
}

function createCityItem(cityData) {
  const cityName = cityData.nom;

  const optionElt             = document.createElement("option");
        optionElt.value       = cityName.toLowerCase();
        optionElt.textContent = cityName.toUpperCase();

  cityListContainer.appendChild(optionElt);
}

function checkInputElt(inputElt) {
  let check;

  inputElt.classList.forEach(className => {
    const regExp = defineRegExp(className);
          check  = (regExp.test(inputElt.value))|| false;
  })

  editInputElt(inputElt, check);
}

function defineRegExp(type) {
  switch(type) {
    case "input-password": 
      regExp = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/;
      break;
      case "input-mail": 
        regExp = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;
        break;
    case "input-phone": 
      regExp = /^[0-9]{10}$/;
      break;
    case "input-zip-code": 
      regExp = /^[0-9]{5}$/;
      break;
  }
  return regExp;
}

function editInputElt(inputElt, checked=true) {
  inputElt.style.borderColor = "#cad1d9";
  inputElt.style.borderWidth = "1px";

  if(!checked && inputElt.value != "") {
    inputElt.style.borderColor = "red";
    inputElt.style.borderWidth = "1.5px";
  }
}

function checkSamePasswords(firstEltId, secondEltId) {
  const firstElt   = document.getElementById(firstEltId);
  const secondElt  = document.getElementById(secondEltId);
  const messageElt = document.getElementById("message-password");

  messageElt.hidden = (firstElt.value === secondElt.value)|| false;
}

/* 
##############################
###          MAIN          ###
##############################
*/

const inputElts         = document.querySelectorAll("input");
const showPasswordElt   = document.getElementById("show-password");
const cityListContainer = document.getElementById("city");

inputElts.forEach(input => {
  input.addEventListener("change", function() {
    checkInputElt(this);

    switch(this.id) {
      case "zip-code": 
        getCityData(this.value);
        break;
      case "password2": 
        checkSamePasswords("password1", "password2");
        break;
      case "password1": 
        checkSamePasswords("password1", "password2");
        break;
    }
  })
})

if(showPasswordElt){
  showPasswordElt.addEventListener("click", function() {
    const inputPasswordElts = document.querySelectorAll(".input-password");
  
    if (this.classList.contains("fa-eye")) {
      inputPasswordElts.forEach(inputElt => {
        inputElt.setAttribute("type", "text");
      })
      this.classList.replace("fa-eye", "fa-eye-slash");
    }
    else if (this.classList.contains("fa-eye-slash")) {
      inputPasswordElts.forEach(inputElt => {
        inputElt.setAttribute("type", "password");
      })
      this.classList.replace("fa-eye-slash", "fa-eye");
    }
  })
}