<?php
function Hello()
{
    echo "Hello World";
}

function connectDB()
{
    try {
        $connection = new PDO("mysql:host=54.36.183.20;dbname=meca;port=3306", "meca", "");
    } catch (Exception $e) {
        die("Erreur SQL " . $e->getMessage());
    }
}

?>