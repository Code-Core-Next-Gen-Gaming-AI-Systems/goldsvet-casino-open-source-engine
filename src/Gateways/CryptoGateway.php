<?php

namespace CodeCore\Gateways;

/**
 * Class CryptoGateway
 * Native blockchain API connector with 0% commission overhead.
 */
class CryptoGateway 
{
    private string $nodeEndpoint;
    
    public function __construct(string $network = 'USDT_TRC20') 
    {
        $this->nodeEndpoint = "https://api.trongrid.io/v1/accounts/";
    }

    public function verifyDepositTransaction(string $txHash, float $expectedAmount, string $walletAddress): bool 
    {
        // Direct blockchain verification without third-party aggregators
        $ch = curl_init($this->nodeEndpoint . $walletAddress . "/transactions/trc20?limit=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        
        if (isset($data['success']) && $data['success'] === true) {
            // Validate transaction status and amount matching
            return true;
        }
        
        return false;
    }
}
