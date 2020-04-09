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

function showResult(container, data) {
  data.forEach(announce => {
    container.appendChild(createAnnounceElement(announce));
  })
}

function createAnnounceElement(data) {
  const liElt = document.createElement("li");
  liElt.className = "search-result-list-item-container";
  liElt.innerHTML = "<a href='#' class='search-result-list-item'><div class='item-picture-container'>  <img src='"+data.picPath+"' alt='announce-picture' class='item-picture'></div><div class='item-description-container'><aside class='item-description-title'>  <h3>"+data.title+"</h3>  <span><i class='fas fa-map-marker-alt'></i> "+data.city.toUpperCase()+"</span></aside><p class='item-description-price'>"+data.price+"</p><p class='item-description-text'>"+data.text+"</p></div></a>";
  return liElt;
}

/* 
##############################
###          MAIN          ###
##############################
*/

const inputElts = document.querySelectorAll("input");
const submitElt = document.querySelector(".submit");

const listElt = document.getElementById("search-result-list");

submitElt.addEventListener("click", (e) => {
  e.preventDefault();
  const monObjet = [
    {
      title: "titre de l'annonce",
      price: "14,00",
      city: "perpignan",
      text: "Je vends cet aspirateur dyson parce que je ne l'utilise pas, on m'en a offert un autre en remplacement, Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, sequi voluptates dignissimos tempora earum adipisci labore ratione unde saepe sed beatae natus libero repellat ipsa totam facilis quaerat cumque optio!",
      picPath: "https://shop.dyson.fr/media/catalog/product/cache/19/image/480x/9df78eab33525d08d6e5fb8d27136e95/n/2/n248f_absolute_hero_378x4202.jpg"
    },
    {
      title: "Montre Super !",
      price: "25",
      city: "canet-en-roussillon",
      text: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, fuga maxime temporibus adipisci nobis, aut ullam officia libero asperiores reiciendis commodi culpa, quam est necessitatibus. Odio eos quaerat neque dicta.",
      picPath: "https://www.luzaka.com/media/catalog/product/cache/1/image/1000x1500/9df78eab33525d08d6e5fb8d27136e95/4/0/40550_3.jpg"
    }
  ];

  showResult(listElt, monObjet);
})