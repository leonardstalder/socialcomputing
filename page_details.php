


<?php


if (isset($_GET['id'])){


?><table style='width:100%;color:black;border:2px solid #444;'>
<thead style=" background:rgba(68, 68, 68, 0.1);margin-bottom:10px" >
      <tr>
         <th>img</th>
         <th>name</th>
	  <th>seller</th>
      </tr>
   </thead>
<tbody>
<?php


	$mysql = new mysqli("127.0.0.1", "socialuser2", "salutsalut", "mydb") or die('There was a problem connecting to the database');
	$stmt = $mysql->prepare("SELECT tbl_clothes.id_cloth, tbl_clothes.cloth_name, tbl_seller.seller_name, tbl_seller.seller_website
FROM tbl_clothes, tbl_seller
WHERE tbl_seller.id_Seller = tbl_clothes.fk_seller
AND id_cloth
IN (".$_GET['id'].")");
	$stmt->execute();
	$stmt->bind_result($id_cloth,$cloth_name,$seller_name, $seller_website);	


 while($row = $stmt->fetch()){
 echo "<tr>";
   echo "<td><img src='clothes_images/".$id_cloth.".jpg'  height='40px' width='30px'></td>"; 
   echo "<td align=center>".substr($cloth_name, 0, 30)."</td>";
   echo "<td><a href='http://".$seller_website."'  target='_blank'>".$seller_name."</a></td>";
  echo "</tr>";
?>

<?php 
 

}
echo " </tbody></table>";
}
?>
