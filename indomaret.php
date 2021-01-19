//Script php
$url_login = "https://edtsapp.indomaretpoinku.com/customer/api/login";
$url_otp = "https://edtsapp.indomaretpoinku.com/customer/api/login-verified";
$url_token = "https://edtsapp.indomaretpoinku.com/coupon/api/mobile/gift/redeem";
$url_redem = "https://edtsapp.indomaretpoinku.com/coupon/api/mobile/coupons?unpaged=true";



$header = [
    'Content-Type: application/json',
    'user-agent: okhttp/4.9.0',
];

///////////////////////////////////
echo "Nomor Hpnya: ";
$input_hp = fopen("php://stdin","r");
$phone = trim(fgets($input_hp));
$phone = "\"$phone\"";
/////////////////////////////////

$idhp = base_convert(microtime(false), 16, 36);
$idhp = "\"$idhp\"";
////////////////////////////////
$data_login = '{"deviceId":'.$idhp.',"phoneNumber":'.$phone.'}';


$hasil_login = sate_ayam($url_login, $header, $data_login);
$pesan_login = json_decode($hasil_login, true);
$pesan_login = $pesan_login['message'];
echo "Pesan : $pesan_login".PHP_EOL;
////////////////////////////////////////
$x = 0;
do {
$otp = input_otp();
$data_otp = '{"deviceId":'.$idhp.',"otp":'.$otp.',"phoneNumber":'.$phone.'}';
$hasil_otp = sate_ayam($url_otp, $header, $data_otp);
$minta_token = json_decode($hasil_otp, true);
$status = $minta_token['status'];
if ($status == '01'){
    $x = 4;
}else {
  $x++;
}
}while ($x < 3);
/// cek otp
    if($status == '03'){
                echo "Mengirim Ulang OTP".PHP_EOL;
                $url_resend = "https://edtsapp.indomaretpoinku.com/customer/api/resend-otp?phoneNumber=$phone";
                $resend = otp_send($url_resend,$header);
                $resend = json_decode($resend, true);
                $status_resend = $resend['status'];
                if ($status_resend == '03'){
                $pesan_ot = $resend['message'];
                echo $pesan_ot;
                die;
                }

                $otp = input_otp();
                $data_otp = '{"deviceId":'.$idhp.',"otp":'.$otp.',"phoneNumber":'.$phone.'}';
                $hasil_otp = sate_ayam($url_otp, $header, $data_otp);
                $minta_token = json_decode($hasil_otp, true);
                $status = $minta_token['status'];}
                if($status == '03'){die;}
        elseif($status == '01'){
            echo "Login Boss".PHP_EOL;
        }