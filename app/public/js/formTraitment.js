function getCityData(zipCode) {
  if(zipCode != "") {
    const url = "https://api-adresse.data.gouv.fr/search/?q="+zipCode+"&type=municipality&limit=50";
    const xhr = new XMLHttpRequest;

    xhr.open("GET", url);

    xhr.onreadystatechange = () => {
      if(xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        showCityName("city", response.features);
      }
    }

    xhr.send(null);
  }
  else {
    showCityName("city");
  }
}

function showCityName(targetEltId, cityList = false) {
  const select = document.getElementById(targetEltId);

  emptySelectElt(select);
  if(cityList) {
    cityList.forEach(city => {
      const cityName = city.properties.name;

      const optionElt             = document.createElement("option");
            optionElt.value       = cityName.toLowerCase();
            optionElt.textContent = cityName.toUpperCase();

      select.appendChild(optionElt);
    });
  }
}

function emptySelectElt(select) {
  while(select.hasChildNodes()) {
    select.removeChild(select.firstChild);
  }
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
  const firstElt = document.getElementById(firstEltId);
  const secondElt = document.getElementById(secondEltId);
  const messageElt = document.getElementById("message-password");

  messageElt.hidden = (firstElt.value === secondElt.value)|| false;
}

/* 
##############################
###          MAIN          ###
##############################
*/

const inputElts = document.querySelectorAll("input");
const showPasswordElt  = document.getElementById("show-password");

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
