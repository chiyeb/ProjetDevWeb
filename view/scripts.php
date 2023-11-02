<?php
// Vos scripts PHP ici
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const messageInput = document.getElementById("message");
        const errorMessage = document.getElementById("message-error");
        const submitButton = document.querySelector(".submit-button");

        messageInput.addEventListener("input", function() {
            const messageLength = messageInput.value.length;
            const maxMessageLength = 150;
            if (messageLength > maxMessageLength) {
                errorMessage.innerText = "Le message ne peut pas dépasser 150 caractères.";
                errorMessage.style.color = "red";
                submitButton.disabled = true;
            } else {
                errorMessage.innerText = "";
                submitButton.disabled = false;
            }
        });
    });
</script>






<script>
    document.addEventListener("DOMContentLoaded", function() {
        const titreInput = document.getElementById("titre");
        const errorMessage = document.getElementById("message-error");
        const submitButton = document.querySelector(".submit-button");

        titreInput.addEventListener("input", function() {
            const titreLength = titreInput.value.length;
            const maxTitreLenght = 75;
            if (titreLength > maxTitreLenght) {
                errorMessage.innerText = "Le titre ne peut pas dépasser 75 caractères.";
                errorMessage.style.color = "red";
                submitButton.disabled = true;
            } else {
                errorMessage.innerText = "";
                submitButton.disabled = false;
            }
        });
    });
</script>



