// Récupérez les éléments du DOM
const modal = document.getElementById('modal');
const modalCat = document.getElementById('modal-cat');
// const modalUser = document.getElementById('modal-user');
const postButton = document.getElementById('post-button');
const postButtonSimple = document.getElementById('post-button-simple');
const postButtonUser = document.getElementById('post-button-user');
const closeButton = document.getElementById('close-button');
const closeButtonCat = document.getElementById('close-button-cat');
const closeButtonUser = document.getElementById('close-button-user');
const catMenu = document.getElementById('post-button-cat');
const catMenuSecond = document.getElementById('post-button-cat2');
// const buttonUser = document.getElementById('post-button-user');




// Affiche la fenêtre modale lorsque le bouton est cliqué
postButton.addEventListener('click', () => {
    modal.style.display = 'block';
});

postButtonSimple.addEventListener('click', () => {
    modal.style.display = 'block';
});


// buttonUser.addEventListener('click', () => {
//     modalUser.style.display = 'block';
// });

catMenu.addEventListener('click', () => {
    modalCat.style.display = 'block';
});

catMenuSecond.addEventListener('click', () => {
    modalCat.style.display = 'block';
});

// Masque la fenêtre modale lorsque le bouton de fermeture est cliqué
closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Masque la fenêtre modale lorsque le bouton de fermeture est cliqué
closeButtonCat.addEventListener('click', () => {
    modalCat.style.display = 'none';
});

// closeButtonUser.addEventListener('click', () => {
//     modalUser.style.display = 'none';
// });

// Masque la fenêtre modale lorsque l'arrière-plan est cliqué
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

window.addEventListener('click', (event) => {
    if (event.target === modalCat) {
        modalCat.style.display = 'none';
    }
});

// window.addEventListener('click', (event) => {
// //     if (event.target === modalUser) {
// //         modalUser.style.display = 'none';
// //     }
// // });



//  Empêche la propagation du clic depuis la fenêtre modale vers l'arrière-plan
//  modal.addEventListener('click', (event) => {
    //   event.stopPropagation();
//   });
