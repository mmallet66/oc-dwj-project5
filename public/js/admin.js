function listenClickOnButtons(arrayButtons) {
    arrayButtons.forEach(button => {
        button.addEventListener('click', function() {
            const confirmed = requestConfirmation(this);
            if(confirmed) {
                document.location.href = '/admin/'+this.name+'/'+this.value;
            }
        })
    });    
}

function requestConfirmation(button) {
    let message = 'Êtes vous sur de vouloir ';
    switch (button.name) {
        case 'delete-user':
            message += 'supprimer l\'utilisateur "'+button.value+'"';
            break;
        case 'remove-announce':
            message += 'supprimer cette annonce ?';
            break;
    }
    return confirm(message);
}

/* 
##############################
###          MAIN          ###
##############################
*/

const buttons = document.querySelectorAll('button');

listenClickOnButtons(buttons);