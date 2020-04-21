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

function maCallback(response) {
    (response === 'true')? redirectToPreviousPage() : passwordError();
}

function redirectToPreviousPage() {
    window.history.go(-1);
}

function passwordError() {
    passwordElt.style.border = '1px solid red';
    passwordElt.value = '';
    passwordElt.placeholder = 'Le mot de passe saisie est erroné';
}

/* 
##############################
###          MAIN          ###
##############################
*/

const usernameElt = document.getElementById('username');
const passwordElt = document.getElementById('password');
const formElt   = document.querySelector('form');

formElt.addEventListener('submit', (e) => {

    const username = usernameElt.value;
    const password = passwordElt.value;

    if(username != '' && password != '') {
        let dataEntered = 'username='+username+'&password='+password;
        ajaxPost(dataEntered, 'http://occazou/connect-user', maCallback);
    }

    e.preventDefault();
})

// 