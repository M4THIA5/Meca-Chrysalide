document.addEventListener('DOMContentLoaded', function () {
    var promoteLinks = document.getElementsByClassName('promote-link');

    Array.prototype.forEach.call(promoteLinks, function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            var userId = this.getAttribute('data-id');
            var username = this.parentNode.parentNode.cells[2].textContent.trim();

            var confirmDialog = confirm("Êtes-vous sûr de vouloir changer les droits de " + username + " ?");

            if (confirmDialog) {
                window.location.href = '../core/promoteUser.php?id=' + userId;
            } else {
                return false;
            }
        });
    });
});