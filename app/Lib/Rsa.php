<?php

/**
 * RSA 公钥/私钥加密/解密
 */

namespace App\Lib;

class Rsa
{

    private $_config;

    public function __construct(?array $rsa_config = null)
    {
        # 加载默认配置
        if(!$rsa_config){
            $rsa_config = config('rsa');
        }

        if (empty($rsa_config['private_key']) && empty($rsa_config['public_key'])) {
            throw new \Exception('请配置公钥或私钥参数');
        }
        $this->_config = $rsa_config;
    }

    /**
     * 私钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串 base64_encode格式
     */
    public function privateKeyEncode($data)
    {
        $this->_needKey(2);
        $private_key = openssl_pkey_get_private($this->_config['private_key']);

        $encrypted = '';

        if(!openssl_private_encrypt($data, $encrypted, $private_key)){ //私钥加密
            throw new \Exception(openssl_error_string(), 1);
        }
        return base64_encode($encrypted);
    }

    /**
     * 公钥加密
     * @param string $data 要加密的数据
     * @return string 加密后的字符串 base64_encode格式
     */
    public function publicKeyEncode($data)
    {
        $this->_needKey(1);
        $public_key = openssl_pkey_get_public($this->_config['public_key']);

        $encrypted = '';

        if(!openssl_public_encrypt($data, $encrypted, $public_key)){ //私钥加密
            throw new \Exception(openssl_error_string(), 1);
        }
        return base64_encode($encrypted);
    }

    /**
     * 用公钥解密私钥加密内容
     * @param string $data 要解密的数据 base64_encode格式
     * @return string 解密后的字符串
     */
    public function decodePrivateEncode($data)
    {
        $this->_needKey(1);
        $public_key = openssl_pkey_get_public($this->_config['public_key']);

        $decrypted = '';
        $data_base64_decode = base64_decode($data);

        if(!openssl_public_decrypt($data_base64_decode, $decrypted, $public_key)){ //私钥加密的内容通过公钥可用解密出来
            throw new \Exception(openssl_error_string(), 1);
        }

        return $decrypted;
    }

    /**
     * 用私钥解密公钥加密内容 
     * @param string $data  要解密的数据 base64_encode格式
     * @return string 解密后的字符串
     */
    public function decodePublicEncode($data)
    {
        $this->_needKey(2);
        $private_key = openssl_pkey_get_private($this->_config['private_key']);

        $decrypted = '';
        $data_base64_decode = base64_decode($data);

        if(!openssl_private_decrypt($data_base64_decode, $decrypted, $private_key)){ //私钥解密
            throw new \Exception(openssl_error_string(), 1);
        }
        return $decrypted;
    }

    /**
     * 检查是否 含有所需配置文件
     * @param int 1 公钥 2 私钥
     * @return int 1
     * @throws Exception
     */
    private function _needKey($type)
    {
        switch ($type) {
            case 1:
                if (empty($this->_config['public_key'])) {
                    throw new \Exception('请配置公钥');
                }
                break;
            case 2:
                if (empty($this->_config['private_key'])) {
                    throw new \Exception('请配置私钥');
                }
                break;
        }
        return 1;
    }
}
