<?php
namespace App;

require_once '../vendor/autoload.php';
use Dotenv\Dotenv;

class SSLEncryption {
    private $encryptionKey;
    
    public function __construct() {
        // Load your environment variables from the project root
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        
        // Load encryption key from .env (must be exactly 32 characters for AES-256)
        $this->encryptionKey = $_ENV['DATA_ENCRYPTION_KEY'];
        
        if (strlen($this->encryptionKey) !== 32) {
            throw new \Exception("Encryption key must be 32 characters long");
        }
    }
    
    // Basic Encryption: returns a base64-encoded string combining IV + ciphertext
    public function encryptData(array $payload) {
        $ivLength = openssl_cipher_iv_length('AES-256-CBC'); // Typically 16 bytes for AES-256
        $iv = openssl_random_pseudo_bytes($ivLength);
        
        // Encode the payload to JSON
        $jsonData = json_encode($payload);
        
        // Encrypt the JSON data using AES-256-CBC in raw data mode
        $encrypted = openssl_encrypt(
            $jsonData,
            'AES-256-CBC',
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        // Prepend the IV to the encrypted data and base64_encode the result
        return base64_encode($iv . $encrypted);
    }
    
    // Basic Decryption: expects the base64 string and returns the decoded array
    public function decryptData($encryptedData) {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        
        // Extract the IV which is at the beginning
        $iv = substr($data, 0, $ivLength);
        // The remaining part is the encrypted payload
        $encrypted = substr($data, $ivLength);
        
        $decrypted = openssl_decrypt(
            $encrypted,
            'AES-256-CBC',
            $this->encryptionKey,
            OPENSSL_RAW_DATA,
            $iv
        );
        
        return json_decode($decrypted, true);
    }
    
    // URL-safe encryption: encrypts and then URL-encodes the result
    public function encryptDataUrlSafe(array $payload) {
        return urlencode($this->encryptData($payload));
    }
    
    // URL-safe decryption: URL-decodes first, then decrypts the result
    public function decryptDataUrlSafe($encryptedData) {
        return $this->decryptData(urldecode($encryptedData));
    }
}

?>