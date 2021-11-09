#!/usr/bin/php
<?PHP

$json = file_get_contents("sales_data.json");
$array = json_decode($json, true);
$product_ids = array();
$total = 0;
$total_vat = 0;
$id_count = 0;

foreach($array as $elem)
{
	foreach ($elem['lines'] as $line)
	{
		$vat = 0;
		$total = $line['qty'] * $line['unit_price_without_vat'];
		if ($line['discount_percentage'])
		{
			$price = $total;
			$total = $total * ((100 - $line['discount_percentage']) /100);
			$total_discount = $total_discount + ($price - $total);
		}
		array_push($product_ids, $line['product']);
		$vat = $vat + ($total * ($line['vat_percentage'] / 100 + 1)) - $total;
		$total_vat = $total_vat + $vat;
	}

}
$unique_products = array_unique($product_ids);
$len = count($unique_products);
echo ("Koko alv euroina: $total_vat €.\n");
echo ("Yhteenlaskettu alennus euroina alv 0%: $total_discount €.\n");
echo ("Uniikkien tuotteiden määrä tilauksilla: $len.\n");
?>