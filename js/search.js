function searchUsers() {
    var searchInput = document.getElementById("search-input").value;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("search-results").innerHTML = xmlhttp.responseText;
        }
    };

    xmlhttp.open("GET", "../core/searchUsers.php?search=" + searchInput, true);
    xmlhttp.send();
}

document.getElementById("search-input").addEventListener("keyup", function (event) {
    if (event.key === "Enter") { // Touche Entrée
        searchUsers();
    }
});

