<?
namespace IPG\Expansion;

Class Soap extends Pogudin
{
    public $login = 'Bitrix';
    public $password = 'Bitrix123';
    public $connect_timeout = 30;
    public $debug_level = 2;	/*	1 - все видят заглушки, 2 - все видят заглушки, админ видит реальные ошибки, 3 - все видят реальные ошибки	*/
    public $wsdl = '';

    public $obClient = false;

    public function MixedParam2Array($value) {
        $arResult = array();

        if (is_array($value)) {
            foreach($value as $key => $obItem)
                    $arResult[$key] = $this->MixedParam2Array($obItem);
        } else {
            // bugfix soap-xml tree
            if (isset($value->item)) {
                $value = (array) $value->item;

                if (array_key_exists(0, $value))
                    $arResult = $this->MixedParam2Array($value);
                else
                    $arResult[] = $this->MixedParam2Array($value);
            } elseif (is_object($value)) {
                $value = (array) $value;
                $arResult = $this->MixedParam2Array($value);
            } else
                $arResult = $value;
        }

        return $arResult;
    }

	public function Connect($wsdl = '') {
        if ($wsdl == '') {
            $this->arLastError['critical'][] = 'URL to wsdl is empty!';
            return false;
        }

        if ($this->wsdl == $wsdl && $this->obClient !== false)
			return true;

        $this->wsdl = $wsdl;

		//set_time_limit($this->connect_timeout + 10);
		ini_set("default_socket_timeout", $this->connect_timeout);

		$arConnectParams = array(
			'trace' => true,
			'exceptions' => true,
			'cache_wsdl' => WSDL_CACHE_NONE,
			//'cache_wsdl' => WSDL_CACHE_DISK,
			'soap_version' => SOAP_1_2,
			'login' => $this->login,
			'password' => $this->password,
			'connection_timeout' => $this->connect_timeout,
			'compression' => SOAP_COMPRESSION_GZIP,
			'keep_alive' => true,
			'user_agent' => 'PHP-SOAP',
			//'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
			//'authentication'=>'SOAP_AUTHENTICATION_DIGEST',
		);

		try {
			$this->obClient = new \SoapClient($this->wsdl, $arConnectParams);
			return true;

		} catch (\SoapFault $e) {
			//$this->SoapError($e,  'WSDL: ' . $this->wsdl);
            throw $e;
            //throw new ExeptionSilent($e->getMessage(), $e->getCode(), $e);
			//return false;
		}
	}

	public function SoapDebug($htmlspecialchars = false) {
		print "<hr />";

        if ($htmlspecialchars) {
            echo "<pre>\n";
            print "<b>Запрос:</b>\n".htmlspecialchars($this->obClient->__getLastRequest()) ."\n";
            //print "Заголовки запроса:\n".htmlspecialchars($this->obClient->__getLastRequestHeaders ()) ."\n";
            print "<b>Ответ:</b>\n".htmlspecialchars($this->obClient->__getLastResponse())."\n";
            print "</pre>";
        } else {
            print "<b>Запрос:</b>\n".$this->obClient->__getLastRequest() ."\n";
            //print "Заголовки запроса:\n". $this->obClient->__getLastRequestHeaders () ."\n";
            print "<b>Ответ:</b>\n". $this->obClient->__getLastResponse() ."\n";
        }

        echo "<hr />";
	}
    /*
    public function SoapError($exeption, $sAdditionalText = '') {
		//$this->SoapDebug();
		
		$this->obClient = false;
		$this->arLastError['critical'][] = $exeption->getMessage() . '. ' . $sAdditionalText;

        $arTrace = $exeption->getTrace();

        echo "<pre>"; print_r($this->arLastError); echo "</pre>";
        return;

        $this->error("SoapError" , array(
            'arLastError' => $this->arLastError,
            'trace0' => $arTrace[0]
            //'getLastResponse' => $this->obClient->__getLastResponse()
        ));
	}
	*/
}
