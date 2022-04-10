<?php
/**$cookie_expiration= time() + (86400 * 30);
if(!isset($_COOKIE['MyAppCookie'])){
    echo "C'est ta première visite!";
    setcookie('MyAppCookie', 1, $cookie_expiration, "/"); // 86400 = Nbre de sécondes dans une journée

}else{
    $nbre= ++$_COOKIE['MyAppCookie'];
    setcookie('MyAppCookie', $nbre, $cookie_expiration, "/");
    echo "Tu as visité l'application ".$_COOKIE['MyAppCookie']. "  fois";
}

**/
// $a non initialisée
$b = 143;
echo $a ?? 3; // affiche 3
echo "<br>";
echo $a ?? $b ?? 7; // affiche 143
echo "<br>";
?>
<form action="traitement.php"       method="post">
    <label for="nom">Nom</label>
    <input type="text" name="nom"  id="nom">
    <label for="prenom">Prénom     </label>
    <input type="text"  name="prenom" id="nom">
    <input type="submit"         name="action" value="OK">
</form>