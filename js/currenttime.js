// Fonction pour obtenir l'heure actuelle au format hh:mm:ss
function getCurrentTime() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    return hours + ':' + minutes + ':' + seconds;
}

// Fonction pour mettre à jour l'heure toutes les secondes
function updateCurrentTime() {
    var currentTimeElement = document.getElementById('current-time');
    if (currentTimeElement) {
        currentTimeElement.textContent = getCurrentTime();
    }
}

// Mettre à jour l'heure initiale
updateCurrentTime();

// Mettre à jour l'heure toutes les secondes
setInterval(updateCurrentTime, 1000);

