<?php
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
    exit;
}

if (!isset($_GET['site'])) {
    http_response_code(400);
    echo json_encode(array('error' => 'Missing parameter: site'));
    exit;
}

$site = $_GET['site'];

// 验证site参数是否为合法URL
if (!filter_var($site, FILTER_VALIDATE_URL)) {
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid parameter: site'));
    exit;
}

// 解析域名到IP地址
$dnsRecords = dns_get_record(parse_url($site, PHP_URL_HOST), DNS_A);
if ($dnsRecords === false || empty($dnsRecords)) {
    http_response_code(500);
    echo json_encode(array('error' => 'Unable to resolve IP address'));
    exit;
}
$ip = $dnsRecords[0]['ip'];

// 测量响应时间
$start_time = microtime(true);

$ch = curl_init($site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_NOBODY, true); // 只取头
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_exec($ch);
$response_time = microtime(true) - $start_time;
curl_close($ch);

// 获取地理位置信息
$geoCh = curl_init("http://ip-api.com/json/$ip?fields=country,regionName,city");
curl_setopt($geoCh, CURLOPT_RETURNTRANSFER, true);
$geoResponse = curl_exec($geoCh);
curl_close($geoCh);

if ($geoResponse === false) {
    http_response_code(500);
    echo json_encode(array('error' => 'Unable to fetch geographic information'));
    exit;
}

$geoData = json_decode($geoResponse, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(array('error' => 'Invalid geographic data'));
    exit;
}

// 返回数据
header('Content-Type: application/json');
echo json_encode(array(
    'ip' => $ip,
    'response_time' => number_format($response_time, 4),
    'location' => array(
        'country' => $geoData['country'],
        'region' => $geoData['regionName'],
        'city' => $geoData['city']
    )
));
?>
