<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$page= $_GET["page"];
$ch = curl_init();

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$page);
curl_setopt($ch, CURLOPT_USERAGENT,
'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_POSTREDIR, 7);

$result = curl_exec($ch);

$obj = json_decode($result);

for ($i=0; $i < count($obj->results) ; $i++) {
  echo'
  <tr>
    <td>'.$obj->results[$i]->name.'</td>
    <td>'.$obj->results[$i]->birth_year.'</td>
    <td>'.$obj->results[$i]->gender.'</td>
    <td><input name="checkbox" data-name="'.$obj->results[$i]->name.'" type="checkbox" class="biggerCheckbox align-text-top" onclick="itemstoArray(\''.$obj->results[$i]->name.'\',\''.$obj->results[$i]->birth_year.'\',\''.$obj->results[$i]->gender.'\')"></td>
  </tr>
  ';
}

echo '<label id="positionInfo" data-next="'.$obj->next.'" data-previous="'.$obj->previous.'" hidden></label>';

curl_close($ch);

?>
