<?php
// Database connection test
// $dbhost = 'db';
// $dbuser = 'root';
// $dbpass = 'root';
// $dbname = 'online_exam';

// // Test database connection
// try {
//     $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "<h2>Database Connection: SUCCESS ✅</h2>";
// } catch(PDOException $e) {
//     echo "<h2>Database Connection: FAILED ❌</h2>";
//     echo "Error: " . $e->getMessage();
// }

// Test PHP extensions
echo "<h2>PHP Extension Status:</h2>";
$required_extensions = [
    'Core', 'date', 'libxml', 'openssl', 'pcre', 'sqlite3', 'zlib', 'ctype', 'curl', 'dom',
    'fileinfo', 'filter', 'hash', 'iconv', 'json', 'mbstring', 'SPL', 'session', 'PDO',
    'pdo_sqlite', 'standard', 'posix', 'random', 'readline', 'Reflection', 'Phar',
    'SimpleXML', 'tokenizer', 'xml', 'xmlreader', 'xmlwriter', 'mysqlnd', 'cgi-fcgi',
    'gd', 'imagick', 'memcached', 'mysqli', 'pdo_mysql', 'redis', 'sodium', 'zip',
    'Zend OPcache','soap'
];
echo "<div style='display: flex; flex-wrap: wrap; gap: 10px; list-style: none; padding: 0;'>";
foreach ($required_extensions as $ext) {
    echo "<div style='background: #f0f0f0; padding: 5px 10px; border-radius: 4px;'>
            $ext: " . (extension_loaded($ext) ? "✅" : "❌") . "
          </div>";
}
echo "</div>";



// Test all extensions systematically
echo "<h2>Comprehensive Extension Tests:</h2>";
echo "<table border='1'>";
echo "<tr><th>Extension</th><th>Status</th><th>Test Details</th></tr>";

foreach ($required_extensions as $ext) {
    echo "<tr><td>$ext</td>";
    if (extension_loaded($ext)) {
        try {
            $testResult = "✅ Loaded";
            switch ($ext) {
                case 'Core':
                case 'standard':
                    $testResult .= " and functional";
                    break;
                case 'date':
                    date('Y-m-d');
                    $testResult .= " and functional";
                    break;
                case 'libxml':
                    libxml_use_internal_errors(true);
                    $testResult .= " and functional";
                    break;
                case 'openssl':
                    openssl_random_pseudo_bytes(1);
                    $testResult .= " and functional";
                    break;
                case 'pcre':
                    preg_match('/test/', 'test');
                    $testResult .= " and functional";
                    break;
                case 'sqlite3':
                    new SQLite3(':memory:');
                    $testResult .= " and functional";
                    break;
                case 'zlib':
                    gzcompress('test');
                    $testResult .= " and functional";
                    break;
                case 'ctype':
                    ctype_alpha('test');
                    $testResult .= " and functional";
                    break;
                case 'curl':
                    curl_init();
                    $testResult .= " and functional";
                    break;
                case 'dom':
                    new DOMDocument();
                    $testResult .= " and functional";
                    break;
                case 'fileinfo':
                    new finfo(FILEINFO_MIME_TYPE);
                    $testResult .= " and functional";
                    break;
                case 'filter':
                    filter_var('test@test.com', FILTER_VALIDATE_EMAIL);
                    $testResult .= " and functional";
                    break;
                case 'hash':
                    hash('sha256', 'test');
                    $testResult .= " and functional";
                    break;
                case 'iconv':
                    iconv('UTF-8', 'UTF-8', 'test');
                    $testResult .= " and functional";
                    break;
                case 'json':
                    json_encode(['test']);
                    $testResult .= " and functional";
                    break;
                case 'mbstring':
                    mb_strlen('test');
                    $testResult .= " and functional";
                    break;
                case 'SPL':
                    new SplStack();
                    $testResult .= " and functional";
                    break;
                case 'session':
                    if (session_status() !== PHP_SESSION_DISABLED) {
                        $testResult .= " and functional";
                    }
                    break;
                case 'PDO':
                    new PDO("sqlite::memory:");
                    $testResult .= " and functional";
                    break;
                case 'pdo_sqlite':
                case 'pdo_mysql':
                    $testResult .= " and functional";
                    break;
                case 'posix':
                    posix_getpid();
                    $testResult .= " and functional";
                    break;
                case 'random':
                    random_bytes(1);
                    $testResult .= " and functional";
                    break;
                case 'readline':
                    if (function_exists('readline')) {
                        $testResult .= " and functional";
                    }
                    break;
                case 'Reflection':
                    new ReflectionClass('stdClass');
                    $testResult .= " and functional";
                    break;
                case 'Phar':
                    if (Phar::canWrite()) {
                        $testResult .= " and functional";
                    }
                    break;
                case 'SimpleXML':
                    simplexml_load_string('<root/>');
                    $testResult .= " and functional";
                    break;
                case 'tokenizer':
                    token_get_all('<?php ?>');
                    $testResult .= " and functional";
                    break;
                case 'xml':
                    xml_parser_create();
                    $testResult .= " and functional";
                    break;
                case 'xmlreader':
                    new XMLReader();
                    $testResult .= " and functional";
                    break;
                case 'xmlwriter':
                    new XMLWriter();
                    $testResult .= " and functional";
                    break;
                case 'mysqlnd':
                    $testResult .= " (MySQL Native Driver)";
                    break;
                case 'cgi-fcgi':
                    $testResult .= " (FastCGI)";
                    break;
                case 'gd':
                    imagecreatetruecolor(1, 1);
                    $testResult .= " and functional";
                    break;
                case 'imagick':
                    new Imagick();
                    $testResult .= " and functional";
                    break;
                case 'memcached':
                    new Memcached();
                    $testResult .= " and functional";
                    break;
                case 'mysqli':
                    new mysqli();
                    $testResult .= " and functional";
                    break;
                case 'redis':
                    new Redis();
                    $testResult .= " and functional";
                    break;
                case 'sodium':
                    sodium_crypto_box_keypair();
                    $testResult .= " and functional";
                    break;
                case 'zip':
                    new ZipArchive();
                    $testResult .= " and functional";
                    break;
                case 'Zend OPcache':
                    if (function_exists('opcache_get_status')) {
                        $testResult .= " and functional";
                    }
                    break;
            }
            echo "<td>$testResult</td><td>No errors</td>";
        } catch (Exception $e) {
            echo "<td>⚠️ Loaded but error</td><td>" . $e->getMessage() . "</td>";
        }
    } else {
        echo "<td>❌ Not loaded</td><td>Extension missing</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Show PHP info for detailed configuration
echo "<h2>PHP Configuration:</h2>";
phpinfo();
?>


<?php 

// Check specifically for JPEG support in GD
if (!function_exists('imagecreatefromjpeg')) {
    die('ERROR: Your PHP GD library does not have JPEG support. Please reinstall it with JPEG support:
    <br>- For Ubuntu/Debian: <code>sudo apt-get install php-gd libjpeg-dev</code> and then <code>sudo apt-get install --reinstall php-gd</code>
    <br>- For CentOS/RHEL: <code>sudo yum install php-gd libjpeg-turbo-devel</code> and then <code>sudo yum reinstall php-gd</code>
    <br>- For Windows: Ensure PHP is compiled with JPEG support
    <br>Then restart your web server.');
}

// Function to check GD supported methods and formats
function checkGDSupport() {
    echo '<h2>GD Library Support Information</h2>';
    
    // Check GD version
    echo '<h3>GD Version</h3>';
    $gdInfo = gd_info();
    echo '<pre>';
    print_r($gdInfo);
    echo '</pre>';
    
    // Check for specific image format support
    echo '<h3>Image Format Support</h3>';
    echo '<ul>';
    echo '<li>JPEG Support: ' . (function_exists('imagecreatefromjpeg') ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . '</li>';
    echo '<li>PNG Support: ' . (function_exists('imagecreatefrompng') ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . '</li>';
    echo '<li>GIF Support: ' . (function_exists('imagecreatefromgif') ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . '</li>';
    echo '<li>BMP Support: ' . (function_exists('imagecreatefrombmp') ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . '</li>';
    echo '<li>WebP Support: ' . (function_exists('imagecreatefromwebp') ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . '</li>';
    echo '</ul>';
    
    // Check for common GD functions
    echo '<h3>Common GD Functions</h3>';
    $gdFunctions = [
        'imagecreatetruecolor' => 'Create true color image',
        'imagettftext' => 'Write text to image using TrueType fonts',
        'imagecopyresampled' => 'Copy and resize part of an image',
        'imagefilter' => 'Apply image filters',
        'imagerotate' => 'Rotate an image',
        'imagealphablending' => 'Alpha blending support'
    ];
    
    echo '<ul>';
    foreach ($gdFunctions as $function => $description) {
        echo '<li>' . $function . ' (' . $description . '): ' . 
             (function_exists($function) ? '<span style="color:green">✓</span>' : '<span style="color:red">✗</span>') . 
             '</li>';
    }
    echo '</ul>';
}


checkGDSupport();