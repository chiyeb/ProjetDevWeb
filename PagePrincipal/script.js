// Récupérez les éléments du DOM
const modal = document.getElementById('modal');
const postButton = document.getElementById('post-button');
const closeButton = document.getElementById('close-button');
const createPostButton = document.getElementById('create-post-button');

// Affiche la fenêtre modale lorsque le bouton est cliqué
postButton.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Masque la fenêtre modale lorsque le bouton de fermeture est cliqué
closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Masque la fenêtre modale lorsque l'arrière-plan est cliqué
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

//  Empêche la propagation du clic depuis la fenêtre modale vers l'arrière-plan
//  modal.addEventListener('click', (event) => {
    //   event.stopPropagation();
//   });
