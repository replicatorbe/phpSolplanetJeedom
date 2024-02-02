

<?

//change ip
$api = "http://192.168.0.x:8484/getdevdata.cgi?device=2&sn=MA30006012290197";
$json = file_get_contents($api);

// Decodage du JSON et recuperation des infos souhaitees
$data = json_decode($json, true);


//requis global variable in jeedom with name, panneau_error,panneau_pac,panneau_vac,panneau_iac,panneau_vpv,panneau_ipv,etC.

if (array_key_exists('err', $data)) {
  $error = $data['err'];
      $scenario->setData('panneau_err', $error);
  $scenario->setLog("Erreur: $error");
}

if (array_key_exists('pac', $data)) {
  $pac = $data['pac'];
      $scenario->setData('panneau_pac', $pac);
  $scenario->setLog("pac: $pac");
}

foreach ($data['vac'] as $voltage) {
  $scenario->setLog("Tension AC: $voltage V");
  $scenario->setData('panneau_vac', $voltage);
}

foreach ($data['iac'] as $current) {
  $scenario->setLog("Courant AC: $current A");
    $scenario->setData('panneau_iac', $current);
}

foreach ($data['vpv'] as $voltage) {
  $scenario->setLog("Tension DC: $voltage V");
    $scenario->setData('panneau_vpv', $voltage);
}

foreach ($data['ipv'] as $current) {
  $scenario->setLog("Courant DC: $current A");
    $scenario->setData('panneau_ipv', $current);

}

$tmp = $data['tmp'];
$scenario->setData('panneau_tmp', $tmp);
$scenario->setLog("Temperature: $tmp ");

$wan = $data['wan'];
$scenario->setData('panneau_wan', $wan);
$scenario->setLog("WATT: $wan WATT");

$etd = $data['etd'];
$scenario->setData('panneau_etd', $wan);
$scenario->setLog("ETD: $etd ");

$energy_produced = $data['eto'];
$scenario->setData('panneau_eto', $energy_produced);
$scenario->setLog("Energie produite: $energy_produced kWh");



?>