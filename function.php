<?php
    function connexionBDD() {
        return new PDO('mysql:host=localhost;dbname=rpg;charset=utf8', 'root', '');
    }
?>