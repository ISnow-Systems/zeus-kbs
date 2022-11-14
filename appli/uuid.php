<?php
function genGUID(bool $useBrackets = false): string
{
	// return: AAAAAAAA-BBBB-4CCC-dDDD-EEEEEEEEEEEE
	$dA = bin2hex(random_bytes(4));
	$dB = bin2hex(random_bytes(2));
	$dC = bin2hex(((random_bytes(2) & 0b0000_1111_1111_1111) | 0x40_00));
	$dD = bin2hex(((random_bytes(2) & 0b0011_1111_1111_1111) | 0b1000_0000_0000_0000));
	$dE = bin2hex(random_bytes(6));
	if ($useBrackets) $rv = "\{$dA-$dB-$dC-$dD-$dE}"; else $rv = "$dA-$dB-$dC-$dD-$dE";
	return strtoupper($rv);
}

function genUUID(int $version = 4, ?string $data = null): string|false
{
	switch ($version) {
		case 3:
			$h = substr(hash("md5", $data, true), 0, 16);
			$hA = bin2hex(substr($h, 0, 4));
			$hB = bin2hex(substr($h, 4, 2));
			$hC = base_convert((intval(bin2hex((substr($h, 6, 2)), 16) & 0b0000_1111_1111_1111) | 0x30_00), 10, 16);
			$hD = base_convert((intval(bin2hex((substr($h, 8, 2)), 16) & 0b0011_1111_1111_1111) | 0b1000_0000_0000_0000), 10, 16);
			$hE = bin2hex(substr($h, 10, 6));
			return strtoupper("$hA-$hB-$hC-$hD-$hD-$hE");
		case 4:
			return genGUID(!is_null($data));
		case 5:
			$h = substr(hash("sha1", $data, true), 0, 16);
			$hA = bin2hex(substr($h, 0, 4));
			$hB = bin2hex(substr($h, 4, 2));
			$hC = bin2hex((substr($h, 6, 2) & 0b0000_1111_1111_1111) | 0x50_00);
			$hD = bin2hex((substr($h, 8, 2) & 0b0011_1111_1111_1111) | 0b1000_0000_0000_0000);
			$hE = bin2hex(substr($h, 10, 6));
			return strtoupper("$hA-$hB-$hC-$hD-$hD-$hE");
		default:
			return false;
	}
}