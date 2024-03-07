<?php

function xmlToJson($xml) {
    $xmlElement = new SimpleXMLElement($xml);
    $xmlElement->registerXPathNamespace('dc', 'http://purl.org/dc/elements/1.1/');
    $xmlElement->registerXPathNamespace('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');

    $data = array();
    $items = $xmlElement->xpath('//item');
    foreach ($items as $item) {
        $earthquake = array();
        $earthquake['title'] = (string)$item->title;
        $earthquake['description'] = (string)$item->description;
        $lat = $item->xpath('.//geo:lat');
        $long = $item->xpath('.//geo:long');
        $earthquake['geo'] = array(
            'lat' => $lat ? (string)$lat[0] : 'Valor no encontrado',
            'long' => $long ? (string)$long[0] : 'Valor no encontrado'
        );
        $data['item'][] = $earthquake;
    }
    return json_encode($data);
}
$xml = file_get_contents("http://www.ign.es/ign/RssTools/sismologia.xml");


$json = xmlToJson($xml);
echo $json;

?>
