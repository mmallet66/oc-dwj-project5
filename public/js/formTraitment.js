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
  let checked = true;
  inputElt.classList.forEach(className => {
    const regExp  = defineRegExp(className);
    if(regExp!=null) {
      if(inputElt.value!="" && !regExp.test(inputElt.value)) {
        checked = false;
        inputElt.classList.add('bad-data');
      }
      else {
        inputElt.classList.remove('bad-data');
      }
    }
  })
  return checked;
}

function defineRegExp(type) {
  let regExp = null;
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
    case "input-price": 
      regExp = /^[1-9]{1}[0-9]*$/;
      break;
    case "input-picture": 
      regExp = /\.(jpg|jpeg|png|gif)$/;
      break;
  }
  return regExp;
}

function editInputElt(inputElt, checked) {
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

  urlEncodedData = urlEncodedDataPairs.join('&').replace('%0D%0A', '\n\r').replace(/%40/g, '@').replace(/%20/g, '_');

  return(urlEncodedData);
}

function getDataEntered(formElement) {
  let data = {};
  let inputElementsList = formElement.querySelectorAll('input');
  let textareaElementsList = (document.querySelectorAll('textarea'));
  let selectElementsList = formElement.querySelectorAll('select');
  (passwordChanged)&& (data['passwordChanged']=passwordChanged);
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
  
  selectElementsList.forEach((selectElt) => {
    switch(selectElt.name) {
      case 'city': 
        let  value               = selectElt.value.split('/');
        data['city_name']        = value[0];
        data['city_region_code'] = value[1];
        break;
      default: 
        data[selectElt.name] = selectElt.value;
        break;
    }
  })

  textareaElementsList.forEach((element) => {
    data[element.name] = element.value;
  })

  return data;
}

function defineNecessaryData() {
  const necessaryData = [];
  if(pageName=='create-announce') {
    necessaryData.push(getValueOf('title'))
    necessaryData.push(getValueOf('text'))
    necessaryData.push(getValueOf('price'))
  }else {
    necessaryData.push(getValueOf('username'))
    necessaryData.push(getValueOf('email'))
    necessaryData.push(getValueOf('city'))
    if(pageName!='userAccount' || passwordChanged) {
      necessaryData.push(getValueOf('password1'))
      necessaryData.push(getValueOf('password2'))
    }
  }
  return necessaryData;
}

function checkNecessaryData(necessaryData) {
  let isCheck = 0;

  necessaryData.forEach((element)=>{
    (element) && isCheck++
  })
  return (necessaryData.length == isCheck)? true: false;
}

function defineDivPasswordContent(passwordChecked=false) {
  const contentUnchecked = '<p><label for="password">Entrez votre mot de passe pour le modifier</label><input type="password" name="password" class="input-password" id="password" autocomplete="off"><i class="fas fa-check icon-password" id="check-password"></i></p>';
  const contentChecked   = '<p><label for="password1">Mot de passe <strong id="message-password" hidden>Mots de passe différents</strong></label><input type="password" name="password1" class="input-password" id="password1" autocomplete="new-password" required><span data-title="Au moins 8 caractères dont 1 min, 1 MAJ et 1 chiffre"></span><i class="fas fa-eye icon-password" id="show-password"></i></p><p><label for="password2">Confirmation du mot de passe</label><input type="password" name="password2" class="input-password" id="password2" autocomplete="new-password" required></p>';

  divPasswordContainer.innerHTML = (passwordChecked)? contentChecked : contentUnchecked;
  listenShowPassword();
  listenChangeEventOnInputElts();
}

function getValueOf(elementId) {
  let element = document.getElementById(elementId)
  return ((document.body.contains(element))&& (element.value!='') && checkInputElt(element))? element.value : false;
}

function listenShowPassword() {
  const showPasswordElt = document.getElementById("show-password");
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
}

function listenChangeEventOnInputElts() {
  const inputElts = document.querySelectorAll("input");
  inputElts.forEach(input => {
    input.addEventListener("change", function() {
      editInputElt(this, checkInputElt(this));
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
}

function listenSubmitEvent(formElt) {
  formElt.addEventListener('submit', function (e) {
    const necessaryData = defineNecessaryData();
    if(checkNecessaryData(necessaryData)){
      let badDataElts = document.getElementsByClassName('bad-data');
      if(badDataElts.length==0) {
        const dataEntered = getDataEntered(this);
        if(pageName!="create-announce") {
          ajaxPost(encode(dataEntered),this.action,(response)=>{
            make(this, response);
          })
          e.preventDefault();
          e.stopPropagation();
        }
      }
      else {
        alert('Au moins un champs est mal rempli');
      }
    }
    else {
      alert('Veuillez remplir tous les champs nécessaires correctement !');
    }
  })
}

function make(formElt, data) {
  let domainRegexp = /^http([s]?):\/\/(.+)\//;
  let action       = formElt.action.replace(domainRegexp,'');
  if(data == true) {
    switch(action) {
      case "new-user": 
        document.location.href = '/connection';
        break;
      case "update-password": 
        alert('Mot de passe changé avec succès');
        passwordChanged = false;
        defineDivPasswordContent();
        break;
      case "update-user": 
        alert('Compte utilisateur mis à jour');
        break;
    }
  } else {
    alert(data);
  }
}

function ifUserAccountPage() {
  if(pageName == 'userAccount') {
    defineDivPasswordContent();
    iconCheckPassword = document.getElementById('check-password');
  
    iconCheckPassword.addEventListener('click', function() {
      let dataEntered = 'username='+document.getElementById('username').value+'&password=' + document.getElementById('password').value;
      ajaxPost(dataEntered, 'http://occazou/connect-user', (response)=>{
        if(response == true) {
          const formPassword        = document.getElementById('update-password');
                formPassword.action = "/update-password";
                passwordChanged     = true;
          defineDivPasswordContent(true);
          listenSubmitEvent(formPassword);
        }
      })
    })
  }
}

function listenDeletionOfAnnouncement() {
  const buttons = document.querySelectorAll('#content-container.userAnnounces button');
  buttons.forEach(button => {
    button.addEventListener('click', function() {
      if(confirm("Êtes vous sûre de vouloir supprimer cette annonce ?")) {
        document.location.href = '/delete-announce/'+this.value;
      }
    });
  })
}

/* 
##############################
###          MAIN          ###
##############################
*/

const pageName             = document.getElementById('content-container').classList[0];
const cityListContainer    = document.getElementById("city");
const formElt              = document.querySelector('form');
const divPasswordContainer = document.getElementById('password-container');
let   iconCheckPassword    = null;
let   passwordChanged      = false;

if(pageName=='userAnnounces') {
  listenDeletionOfAnnouncement();
}
else {
  listenShowPassword();
  listenChangeEventOnInputElts();
  listenSubmitEvent(formElt);
  ifUserAccountPage();
}