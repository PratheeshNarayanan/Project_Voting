<?php
include("../connection.php");
include("table.php");
$result = mysqli_query($con,"SHOW FIELDS FROM $table");
$i = 0;
while ($row = mysqli_fetch_array($result))
 {
 // echo $row['Field'] . ' ' . $row['Type']."<br>";
  $name=$row['Field'];
  //echo $name."<br>";
  $post_values[]=addslashes($_POST[$name]);
  $field_name[]=$name;
  $data_type[]=$row['Type'];
 // echo $post_values[$i];
  $i++;
 }
$j=$i;
//echo "<br>";
for($k=0;$k<$i;$k++)
{
	if($fields=="")
	$fields=$field_name[$k];
	else
	$fields=$fields.",".$field_name[$k];
	
	
	$type=$data_type[$k];
	//$data_type[$k];
	$type = explode("(", $type);
  $type_only=$type[0];
	
	

  if($type_only=='tinytext')
  {
	

$date=date("Y-m-d-h-i-s");
$target_path = $target_path.$date.basename($_FILES[$field_name[$k]]['name']); 
$target_path2 = $date.basename($_FILES[$field_name[$k]]['name']); 
//echo $target_path;
move_uploaded_file($_FILES[$field_name[$k]]['tmp_name'], $target_path);





	if($datas=="")
	{
	$datas="'".$target_path2."'";
	//echo $field_name[$k];
	}
	else
	{
	$datas=$datas.",'".$target_path2."'";
//	echo $field_name[$k];
	}
	
  }
  
  
  else
	 {
	if($datas=="")
	$datas="'".$post_values[$k]."'";
	else
	$datas=$datas.",'".$post_values[$k]."'";
	
  }
}
//echo $datas;

mysqli_query($con,"INSERT INTO $table($fields) VALUES ($datas)") or die("error 2".mysqli_error($con));


$insert_id=mysqli_insert_id($con);










$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 4096,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
    
// Create the private and public key
$res = openssl_pkey_new($config);

// Extract the private key from $res to $privKey
openssl_pkey_export($res, $privKey);

// Extract the public key from $res to $pubKey
$pubKey = openssl_pkey_get_details($res);
$pubKey = $pubKey["key"];

//$data = 'plaintext data goes here';
//echo "PUBLIC KEY : <br>".$pubKey."<br>";
// Encrypt the data to $encrypted using the public key
openssl_public_encrypt($data, $encrypted, $pubKey);
//echo "PUBLIC KEY : <br>".$privKey."<br>";
// Decrypt the data using the private key and store the results in $decrypted
openssl_private_decrypt($encrypted, $decrypted, $privKey);

//echo $decrypted;

//echo $insert_id;
mysqli_query($con,"update tbl_voter set public_key='$pubKey',private_key='$privKey' where id='$insert_id'") or die("error".mysqli_error($con));










header("location:form.php?a=1");
?>
