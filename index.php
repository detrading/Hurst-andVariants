<?PHP
require_once("../authenticate.php");
require_once("../mathfunctions.php");

$sql ="SELECT   `last1` FROM `coinmktcap_entries_new2`  WHERE `market` = 'BTC-RCN' AND  `datetime_now` > DATE_SUB(NOW(), INTERVAL 24 HOUR) ORDER BY `ent_id` ASC ; ";

$vals = array();
$queryres = $mysqli->prepare($sql) or trigger_error($mysqli->error."[$sql]");
$queryres->execute();
$queryres->bind_result($last);
		
while ($queryres->fetch()){ 
	$vals[] = $last;
 }
 
 //echo '<pre>'; print_r($vals); echo '</pre>';
echo PHP_EOL, count($vals);
$val_count = count($vals);

 /*
 a. Size of range is the entire data series = one range of 15,821 daily returns.

b. Size of each range is 1/2 of the entire data series = 15,821 ÷ 2 = two ranges of either 7,911 or 7,910 daily returns.

c. Size of each range is 1/4 of the entire data series = 15,821 ÷ 4 = four ranges of either 3,956 or 3,955 daily returns.

d. Size of each range is 1/8 of the entire data series = 15,821 ÷ 8 = eight ranges of either 1,978 or 1,977.

e. Size of each range is 1/16 of the entire data series = 15,821 ÷ 16 = sixteen ranges of either 989 or 988 daily returns.

f. Size of each range is 1/32 of the entire data series = 15,821 ÷ 32 = thirty-two ranges of either 495 or 494 daily returns.

*/






///// /////
#    https://stackoverflow.com/questions/15723059/split-array-into-a-specific-number-of-chuncks
///// /////
function partition(Array $list, $p) {
    $listlen = count($list);
    $partlen = floor($listlen / $p);
    $partrem = $listlen % $p;
    $partition = array();
    $mark = 0;
    for($px = 0; $px < $p; $px ++) {
        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
        $partition[$px] = array_slice($list, $mark, $incr);
        $mark += $incr;
    }
    return $partition;
}

//echo '<pre>', print_r(partition($vals, 4)), '</pre>';

//$range[0] = $vals;
$range[1] = partition($vals, 2);
$range[2]  = partition($vals, 4);
$range[3]  = partition($vals, 8);
$range[4]  = partition($vals, 16);
$range[5]  = partition($vals, 32);
$range[6]  = partition($vals, 64);

foreach ($range as $indrange){
	
	foreach (  $indrange as $arraypart ){
		
		$m = simpleAverage($arraypart);
		echo  $m, PHP_EOL;
	}
	
	echo 'Z', '<BR>', '<BR>';
}





//echo '<pre>', print_r($range6arrayof), '</pre>';

