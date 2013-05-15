<?php
// CONFIGURE BELOW
$esHostProtocol = 'http'; // could be https, but may require changes to CURL opts?
$esHost = 'localhost';
$esPort = '9200';
$indexName = 'comicbook';
$docType = 'superhero';
$documentId = 1;

// DO NOT EDIT BELOW THIS LINE!
$row = 1;
if (($handle = fopen('indexme.csv', "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 300, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        $hero = $data[0];
        $summary = $data[1];
        echo 'INDEXING ROW: ' . $row . ' HERO: ' . $hero . "\n";

        $json_data = array(
            "name" => $hero,
            "summary" => $summary
        );
        $jsonData = json_encode($json_data);

        $endPointURL = $esHostProtocol . '://' . $esHost . ':' . $esPort . '/' . $indexName . '/' . $docType . '/' . $documentId++;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endPointURL);
        curl_setopt($ch, CURLOPT_PORT, $esPort);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        $response = curl_exec($ch);
        echo 'RESPONSE: ' . $response . "\n\n";
        if (!$response) {
            return false;
        }
    }
    fclose($handle);
}
?>