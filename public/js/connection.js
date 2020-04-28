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

function checkResponse(response) {
    (response == true)? redirect() : passwordError();
}

function redirect() {
    const registrationUrl = 'http://occazou/registration';
    const disconnectUserUrl = 'http://occazou/disconnect-user';
    (document.referrer == registrationUrl || document.referrer == disconnectUserUrl)? document.location.href='/' : window.history.go(-1);
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
        ajaxPost(dataEntered, 'http://occazou/connect-user', checkResponse);
    }

    e.preventDefault();
})

// 