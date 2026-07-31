<?php 


$con = new mysqli("localhost","root","","reidoacai");

$sql = "SELECT * FROM produto";

$resultado = $con->query($sql);

while($produto = $resultado->fetch_assoc()){
?>

<img src="<?php echo $produto['IMAGEM']; ?>" alt="Produto">

<?php
}
?>
<img src="<?php echo $produto['IMAGEM']; ?>" alt="Produto">

?> 