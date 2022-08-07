<?php
namespace Codio\PaymentGateway\Requests;

/**
 * Class PaymentGatewayHTTPClient
 * @package Codio\PaymentGateway\Requests
 */
class PaymentGatewayHTTPClient implements PaymentGatewayHTTPClientInterface
{
    protected $url;
    protected $body;
    protected $ssl;
    protected $debug = false;
    protected $strictSSL = true;
    protected $debugToFile;
    protected $debugFileDescriptor;

    /**
     * PaymentGatewayHTTPClient constructor.
     *
     * @param string $url
     * @param null $body
     * @param null $ssl
     * @param bool $strictSSL
     */
    public function __construct
    (
        $url,
        $body = null,
        $ssl = null,
        $strictSSL = true
    )
    {
        $this->url = $url;
        $this->body = $body;
        $this->ssl = $ssl;
        $this->strictSSL = $strictSSL;
    }

    /**
     * Set debug to log file
     *
     * @param string $path_to_file
     */
    final public function setDebugToFile($path_to_file)
    {
        $this->debug = true;
        $this->debugToFile = $path_to_file;
        $this->debugFileDescriptor = fopen($path_to_file, 'w+');
    }

    /**
     * Executes request and returns instance of result object
     *
     * @return PaymentGatewayHTTPClientResult
     */
    final public function execute()
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_VERBOSE, $this->debug);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/xml',
            'Content-Length: '.strlen($this->body)
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->body);

        if ($this->ssl) {
            $sslCert = $this->ssl['cert'];
            $sslkey = $this->ssl['key'];
            $sslCertPass = $this->ssl['keyPass'];
            curl_setopt($ch, CURLOPT_SSLCERT, $sslCert);
            curl_setopt($ch, CURLOPT_SSLKEY, $sslkey);
            curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $sslCertPass);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        if ($this->debug) {
            curl_setopt($ch, CURLOPT_STDERR, $this->debugFileDescriptor);
            fputs($this->debugFileDescriptor, "URL: " . $this->url);
            fputs($this->debugFileDescriptor, "BODY: \n" . var_export($this->body, true));
        }

        $output = curl_exec($ch);
        $info = curl_getinfo($ch);

        if ($this->debug) {
            fputs($this->debugFileDescriptor, "INFO: \n" . var_export($info, true));
            fputs($this->debugFileDescriptor, "OUTPUT: \n" . var_export($output, true));
        }

        return new PaymentGatewayHTTPClientResult(
            $output,
            $info
        );
    }
}
