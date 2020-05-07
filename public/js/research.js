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
  ANNOUNCE_LIST_LENGTH = data.length;
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

function research() {
  REQUEST = where+'--'+subject+'/'+PAGE;
  ajaxGet(url+REQUEST, (response) => {
    whatSearchElt.textContent = capitalize(subject)+' à '+capitalize(where);
    showResult(response);
    definePaginationLinks();
  });
}

function definePaginationLinks() {
  const paginationContainer = document.getElementById('pagination-container');
  paginationContainer.innerHTML = '';
  const previousLink = document.createElement('a');
  const nextLink = document.createElement('a');
  const separator = document.createElement('p');

  previousLink.href = '#';
  nextLink.href = '#';
  previousLink.innerText = 'Précédent';
  nextLink.innerText = 'Suivant';
  separator.innerText = ' - ';

  defineEventsListener([previousLink, nextLink]);

  if(PAGE == 1) {
    if(ANNOUNCE_LIST_LENGTH == 5) {
        paginationContainer.appendChild(nextLink);
      }
  }
  else if(PAGE > 1) {
    if(ANNOUNCE_LIST_LENGTH < 5) {
      paginationContainer.appendChild(previousLink);
    }
    else {
      paginationContainer.appendChild(previousLink);
      paginationContainer.appendChild(separator);
      paginationContainer.appendChild(nextLink);
    }
  }

}

function defineEventsListener(elements) {
  elements.forEach((element) => {
    element.addEventListener('click', (e)=>{
      switch (e.target.textContent) {
        case 'Précédent':
          PAGE -= 1;
          break;
        case 'Suivant':
          PAGE += 1;
          break;
      }
      research();
      e.preventDefault();
    })
  })
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
let subject = null;
let where = null;
let REQUEST = null;
let ANNOUNCE_LIST_LENGTH = null;
let PAGE = 1;

submitElt.addEventListener("click", (e) => {
  e.preventDefault();
  subject = document.getElementById("research-subject").value;
  where = document.getElementById("research-location").value;
  research();
})