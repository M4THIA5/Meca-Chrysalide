// Attendre que la page soit chargée
window.addEventListener('DOMContentLoaded', function () {
    var commentButtons = document.querySelectorAll('.comment-button');

    // Pour chaque bouton, ajouter un gestionnaire d'événement pour afficher la fenêtre contextuelle
    commentButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            var produitId = button.getAttribute('data-produit-id');

            // Appeler une fonction pour charger les commentaires du produit spécifique et afficher la fenêtre contextuelle
            loadAndDisplayComments(produitId);
        });
    });

    // Fonction pour charger et afficher les commentaires dans la fenêtre contextuelle
    function loadAndDisplayComments(produitId) {
        // Créer la fenêtre contextuelle
        var popup = document.createElement('div');
        popup.classList.add('popup');

        // Créer la croix de fermeture
        var closeButton = document.createElement('span');
        closeButton.classList.add('popup-close');
        closeButton.textContent = 'X';

        // Ajouter la croix de fermeture à la fenêtre contextuelle
        popup.appendChild(closeButton);

        // Créer le formulaire de commentaire
        var commentForm = document.createElement('form');
        commentForm.setAttribute('method', 'post');
        commentForm.setAttribute('action', 'add_comment.php');

        // Champ de texte pour le commentaire
        var commentInput = document.createElement('textarea');
        commentInput.setAttribute('name', 'commentaire');
        commentInput.setAttribute('placeholder', 'Laissez un commentaire...');
        commentInput.setAttribute('required', 'required');
        commentInput.style.width = '90%';
        commentInput.style.height = '100px';
        commentForm.appendChild(commentInput);

        // Champ caché pour stocker l'ID du produit
        var produitIdInput = document.createElement('input');
        produitIdInput.setAttribute('type', 'hidden');
        produitIdInput.setAttribute('name', 'produitId');
        produitIdInput.setAttribute('value', produitId);
        commentForm.appendChild(produitIdInput);

        // Bouton de soumission du formulaire
        var submitButton = document.createElement('button');
        submitButton.setAttribute('type', 'submit');
        submitButton.textContent = 'Envoyer';
        commentForm.appendChild(submitButton);

        // Ajouter le formulaire à la fenêtre contextuelle
        popup.appendChild(commentForm);

        // Ajouter la fenêtre contextuelle à la page
        document.body.appendChild(popup);

        // Gérer la fermeture de la fenêtre contextuelle en cliquant sur la croix ou en dehors de la fenêtre
        closeButton.addEventListener('click', function () {
            document.body.removeChild(popup);
        });

        window.addEventListener('click', function (event) {
            if (event.target === popup) {
                document.body.removeChild(popup);
            }
        });

        // Gérer la soumission du formulaire de commentaire
        commentForm.addEventListener('submit', function (event) {
            event.preventDefault();

            // Récupérer le contenu du commentaire
            var commentaire = commentInput.value;

            // Appeler une fonction pour enregistrer le commentaire en base de données
            submitComment(produitId, commentaire);
        });
    }

    // Fonction pour soumettre le commentaire en base de données
    function submitComment(produitId, commentaire) {
        // Effectuer une requête Ajax pour envoyer le commentaire au serveur
        // Par exemple, vous pouvez utiliser fetch() pour envoyer les données au script PHP qui traitera l'enregistrement en base de données
        fetch('add_comment.php', {
            method: 'POST',
            body: JSON.stringify({
                produitId: produitId,
                commentaire: commentaire
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(function (response) {
                if (response.ok) {
                    // Le commentaire a été enregistré avec succès
                    // Vous pouvez mettre à jour l'affichage des commentaires ou effectuer d'autres actions si nécessaire
                    console.log('Le commentaire a été enregistré avec succès.');
                } else {
                    // Une erreur s'est produite lors de l'enregistrement du commentaire
                    console.log('Une erreur s\'est produite lors de l\'enregistrement du commentaire.');
                }
            })
            .catch(function (error) {
                console.log('Une erreur s\'est produite :', error);
            });
    }
});
