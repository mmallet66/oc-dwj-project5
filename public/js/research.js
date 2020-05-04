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

function getDataEntered() {
  const dataEntered = [];
  inputElts.forEach(input => {
    if(!input.classList.contains("submit")){
      dataEntered.push(input.value);
    }
  })
  return dataEntered;
}

function showResult(data) {
  listElt.innerHTML = '';
  data.forEach(announce => {
    listElt.appendChild(createAnnounceElement(announce));
  })
}

function createAnnounceElement(announce) {
  const liElt = document.createElement("li");
  liElt.className = "search-result-list-item-container";
  liElt.innerHTML = "<a href='/announce/"+announce.id+"' class='search-result-list-item'><div class='item-picture-container'><img src='/"+announce.picture+"' alt='announce-picture' class='item-picture'></div><div class='item-description-container'><aside class='item-description-title'><h3>"+escapeHtml(announce.title)+"</h3><span><i class='fas fa-map-marker-alt'></i> "+announce.city.toUpperCase()+"</span></aside><p class='item-description-price'>"+escapeHtml(announce.price)+"€</p><p class='item-description-text'>"+escapeHtml(announce.text)+"</p></div></a>";
  return liElt;
}

function escapeHtml(text) {
  const charList = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
 
  return text.replace(/[&<>"']/g, function(char) { return charList[char]; });
}

function capitalize(s) {
  return s.charAt(0).toUpperCase() + s.slice(1)
}

/* 
##############################
###          MAIN          ###
##############################
*/

const submitElt = document.querySelector(".submit");
const listElt = document.getElementById("search-result-list");
const whatSearchElt = document.getElementById("what-search");
const url = 'http://occazou/search/';

console.log(whatSearchElt.textContent);
submitElt.addEventListener("click", (e) => {
  e.preventDefault();

  const subject = document.getElementById("research-subject").value;
  const location = document.getElementById("research-location").value;
  const request = location+'--'+subject;
  ajaxGet(url+request, (response) => {
    whatSearchElt.textContent = capitalize(subject)+' à '+capitalize(location);
    showResult(response)
  });
})