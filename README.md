# Intégration des données de l'onduleur Solplanet dans Jeedom

## Description
Ce guide explique comment récupérer les données de l'onduleur Solplanet et les stocker dans les variables globales de Jeedom en utilisant un scénario. Vous pouvez suivre ces étapes pour intégrer ces données dans votre système Jeedom.

## Prérequis
- Un système Jeedom en cours d'exécution
- L'onduleur Solplanet
- Connexion réseau entre Jeedom et l'onduleur Solplanet

## Étapes

### Étape 1 : Création d'un scénario et virtuel dans Jeedom 
1. Dans l'interface Jeedom, allez dans "Scénarios" et créez un nouveau scénario ou utilisez un scénario existant.
2. Creez des variables globales dans Jeedom avec les noms suivants : panneau_err, panneau_pac, panneau_vac, panneau_iac, panneau_vpv, panneau_tmp, panneau_wan, panneau_etd, panneau_eto

### Étape 2 : Copiez le code PHP
1. Copiez le code PHP suivant et collez-le dans le scénario que vous avez créé. Assurez-vous de le placer dans une action appropriée qui sera déclenchée selon vos besoins.

```php




//change this ip for call in Solplanet
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



```

### Étape 3 : Personnalisation
Assurez-vous de personnaliser l'URL de l'API en fonction de l'adresse de votre onduleur Solplanet et du numéro de série (sn) approprié.


### Étape 4 : Déclenchement
Configurez le déclenchement du scénario en fonction de vos besoins, par exemple, en fonction d'une planification ou d'un événement particulier.


### Étape 5 : Exécution
Enregistrez et activez le scénario. Il récupérera les données de l'onduleur Solplanet et les stockera dans les variables globales de Jeedom.
C'est tout ! Vous avez maintenant réussi à intégrer les données de l'onduleur Solplanet dans Jeedom grâce à ce scénario. Vous pouvez utiliser les variables globales pour surveiller et automatiser votre système en fonction des données de l'onduleur Solplanet. Vous pouvez maintenant simplement ajouter un virtuel et lire les données de la variable globale dans le virtuel et vous aurez la valeur dans votre dashboard!

