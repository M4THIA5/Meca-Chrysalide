<?php session_start(); ?>
<?php require('../core/functions.php'); ?>
<?php require('../conf.inc.php'); ?>
<?php include('../template/head.php'); ?>
<?php include('../template/navbar.php'); ?>

<h1 class="registertitle"> S'inscrire </h1>
<div class="register">
    <div>
        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo '<div>' . $error . '</div>';
            }
            unset($_SESSION['errors']);
        }
        ?>

        <form action="../core/registerUser.php" method="POST">
            <input class="form-control" name="lastname" id="lastname" placeholder="Votre Nom" required="required">
            <input class="form-control" name="firstname" id="firstname" placeholder="Votre prénom" required="required">

            <label for="birthday" class="form-label">
                Votre date de naissance :
            </label>

            <input class="form-control" type="date" id="birthday" name="birthday" placeholder="Votre date de naissance"
                required="required">
            <div class="col-md-6">
                <input class="form-control" type="email" name="email" placeholder="Votre email" required="required">

                <input class="form-control" type="password" name="pwd" id="pwd" placeholder="Votre mot de passe"
                    required="required">

                <input class="form-control" type="password" name="pwdConfirmation" id="pwdConfirmation"
                    placeholder="Confirmez votre mot de passe" required="required">

                <label for="cgu">J'accepte les CGU
                    <a href="cgu.php" target="_blank">(Conditions Générales d'Utilisation)</a>

                </label>
                <input class="form-check-input" type="checkbox" name="cgu" id="cgu">
                <div id="capcha">
                    <?php
                    gdImage(selectImageForCapcha());
                    $capcha = glob(pathCapcha . "/MecaChrysalide/assets/capcha/imagesDecoupe/*.jpg");
                    foreach ($capcha as $key => $image) {
                        if ($key % 3 == 0) {
                            echo '<br>';
                        }
                        echo '<img id="image-piece' . $key . '" style="border:4px solid white" src="../assets/capcha/imagesDecoupe/image' . $key . '.jpg" alt="Image GD Capcha">';
                    }
                    echo '<br>'
                        ?>
                </div>
                <label>
                    <button id="submitBtn" disabled>S'inscrire</button>
                </label>
            </div>

    </div>

    </form>
</div>
</div>
<div>
    <p>
        Vous êtes déjà inscrit ? <a href="../login.php"><u>Connectez-vous</u></a>
    </p>
</div>
<script>
    // Fonction pour mélanger les morceaux d'image
    function shuffleImagePieces(imagePieces) {
        for (let i = imagePieces.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [imagePieces[i].src, imagePieces[j].src] = [imagePieces[j].src, imagePieces[i].src];
        }
    }

    // Fonction pour intervertir les images
    function swapImages(index1, index2) {
        const tempSrc = imageMelange[index1].src;
        imageMelange[index1].src = imageMelange[index2].src;
        imageMelange[index2].src = tempSrc;
    }
    // Variable pour stocker l'indice de la première image sélectionnée
    let firstImageIndex = -1;

    function handleClick(event) {
        const clickedImage = event.target;
        const clickedImageIndex = imageMelange.indexOf(clickedImage);

        // Si aucune image n'a été sélectionnée auparavant
        if (firstImageIndex === -1) {
            firstImageIndex = clickedImageIndex;
            clickedImage.classList.add('selected');
        }
        // Si une image a déjà été sélectionnée
        else {
            // Intervertir les images
            swapImages(firstImageIndex, clickedImageIndex);

            // Réinitialiser la sélection
            imageMelange[firstImageIndex].classList.remove('selected');
            firstImageIndex = -1;
        }
    }

    function capchaIsResolved(tab1, tab2) {
        // Vérifier si les tableaux ont la même longueur
        if (tab1.length !== tab2.length) {
            return false;
        }
        // Parcourir les éléments des tableaux
        for (let i = 0; i < tab1.length; i++) {
            // Comparer les valeurs correspondantes
            if (tab1[i] !== tab2[i].currentSrc) {
                return false;
            }
        }
        return true;
    }

    function sleep(millisecond) {
        return new Promise(function (resolve, reject) {
            setTimeout(function () {
                resolve();
            }, millisecond);
        })
    }

    function testCaptcha() {
        if (capchaIsResolved(imageOrigin, imageMelange)) {
            submitBtn.removeAttribute('disabled');
        } else {
            submitBtn.setAttribute('disabled', true); // Désactiver le bouton
            sleep(2000).then(function () {
                testCaptcha();
            });
        }
    }

    let imageOrigin = [];
    for (let i = 0; i < 9; i++) {
        const imagePiece = document.querySelector('#image-piece' + i);
        imageOrigin.push(imagePiece.currentSrc);
    }


    let imageMelange = [];
    for (let i = 0; i < 9; i++) {
        const imagePiece = document.querySelector('#image-piece' + i);
        imageMelange.push(imagePiece);
    }
    shuffleImagePieces(imageMelange);

    // Ajouter un gestionnaire de clic à chaque image
    imageMelange.forEach((image) => {
        image.addEventListener('click', handleClick);
    });
    document.addEventListener('DOMContentLoaded', function () {
        const submitBtn = document.getElementById('submitBtn');
        testCaptcha();
    });

</script>
<?php include('../template/footer.php'); ?>