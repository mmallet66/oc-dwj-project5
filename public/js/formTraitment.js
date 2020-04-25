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

function ajaxPost(data, url, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', url);

  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

  xhr.onreadystatechange = () => {
      if(xhr.readyState === 4 && xhr.status === 200) {
          callback(xhr.responseText);
      }
  }
  
  xhr.send(data);
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
  const cityName   = cityData.nom;
  const regionCode = cityData.codeRegion;
  
  const optionElt             = document.createElement("option");
        optionElt.value       = cityName.toLowerCase()+'/'+regionCode;
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

function encode(data) {
  let urlEncodedData      = "";
  let urlEncodedDataPairs = [];
  let name;

  for(name in data) {
    urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
  }

  urlEncodedData = urlEncodedDataPairs.join('&').replace(/%40/g, '@').replace(/%20/g, '_');

  return(urlEncodedData);
}

function getDataEntered(formElement) {
  let data              = {};
  let inputElementsList = formElement.querySelectorAll('input');
  let selectElementList = formElement.querySelectorAll('select');

  inputElementsList.forEach((inputElt) => {
    if(inputElt.type!='submit' && inputElt.name!='password2') {
      switch(inputElt.name) {
        case 'password1': 
          data['password'] = inputElt.value;
          break;
        case 'zip-code': 
          data['city_zipCode'] = inputElt.value;
          break;
        default: 
          data[inputElt.name] = inputElt.value;
          break;
      }
    }
  })
  
  selectElementList.forEach((selectElt) => {
    switch(selectElt.name) {
      case 'city':
        let value = selectElt.value.split('/');
        data['city_name'] = value[0];
        data['city_regionCode'] = value[1];
        break;
      default: 
        data[selectElt.name] = selectElt.value;
        break;
    }
  })

  return data;
}

function checkNecessaryData() {
  const necessaryData = [];
  necessaryData.push(document.getElementById('username').value)
  necessaryData.push(document.getElementById('password1').value)
  necessaryData.push(document.getElementById('password2').value)
  necessaryData.push(document.getElementById('email').value)
  necessaryData.push(document.getElementById('city').value)

  let isCheck = 0;

  necessaryData.forEach((element)=>{
    (element != '') && isCheck++
  })

  return isCheck;
}

/* 
##############################
###          MAIN          ###
##############################
*/

const inputElts         = document.querySelectorAll("input");
const showPasswordElt   = document.getElementById("show-password");
const cityListContainer = document.getElementById("city");
const formElts          = document.querySelectorAll('form');

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

formElts.forEach((form) => {
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    e.stopPropagation();

    if(checkNecessaryData() == 5){

      let dataEntered = getDataEntered(this);

      ajaxPost(encode(dataEntered),this.action,(response)=>{
        (response == 1)? document.location.href = '/connection' : alert(response);
      })
        
    }
    else {
      alert('Veuillez remplir tous les champs nécessaires !');
    }
  })
})
