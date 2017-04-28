<?
namespace IPG\Expansion;

Class SoapSync extends Soap
{
    private $ar1CServers = array(
        array(
            'IP' => '192.168.0.100',
            'DB' => 'work'
        )
    );

    public function NewOrder($arParam) {
        try{
//$start = microtime(true);

            $this->Connect('WebServ');

            $result = $this->obClient->NewOrder($arParam);

            if (strlen($result->return->Error) > 0)
                throw new ExceptionC("Soap NewOrder error: " . $result->return->Error, false, 0);

//$time = microtime(true) - $start."\n-----------------------------------------\n";

//file_put_contents("/home/bitrix/www/log1.log",print_r($arParam, true), FILE_APPEND);
            return $result->return->Result;

        } catch (\SoapFault $e) {
            $this->SoapDebug(true);
            throw new ExeptionC("Soap NewOrder: " . $e->getMessage(), false, $e->getCode(), $e);
        }
    }

    public function GetProductStatus($arID) {
        try{
            $this->Connect('WebServ');
            $arParam = array(
                'Id' => $arID
            );
            //echo "Исходящие параметры:<pre>"; print_r($arParam); echo "</pre>";

            $result = $this->obClient->GetProductStatus($arParam);

            if (strlen($result->return->Error) > 0)
                throw new ExceptionC("Soap GetProductStatus error: " . $result->return->Error, false, 0);

            $result = $this->MixedParam2Array($result->return->Result);
            return (is_array($result) ? $result : array($result));

        } catch (SoapFault $e) {
            throw new ExeptionC("Soap GetProductStatus", false, 0, $e);
        }
    }

    public function CycleArray($arArray = false, $mStartKey = false) {
        static $arStaticArray;

        if (is_array($arArray)) {
            $arStaticArray = $arArray;
            reset($arStaticArray);

            if (!$mStartKey) {
                return array(key($arStaticArray) => current($arStaticArray));
            } else {
                if(!array_key_exists($mStartKey, $arStaticArray))
                    return false;

                if (key($arStaticArray) == $mStartKey)
                    return array(key($arStaticArray) => current($arStaticArray));

                while ($arNext = $this->CycleArray()) {
                    if (key($arNext) == $mStartKey)
                        return array(key($arNext) => current($arNext));
                }
            }
        } else {
            if (!$next = next($arStaticArray)) {
                $next = reset($arStaticArray);
            }
            return array(key($arStaticArray) => $next);
        }
    }

    public function Connect($wsdl) {
        $iRetryMax = count($this->ar1CServers);

        static $iLastServer;
        if (empty($iLastServer))
            $iLastServer = 0;

        $arResultConnect = array();
        $arServerArray = $this->CycleArray($this->ar1CServers, $iLastServer);
        $iRetryCounter = 0;

        do {
            $arServer = current($arServerArray);
            $key = key($arServerArray);

            $iRetryCounter++;
            $wsdlConnect = "http://{$arServer['IP']}/{$arServer['DB']}/ws/$wsdl?wsdl";

            try {
                $arResultConnect[ $iRetryCounter ] = parent::Connect($wsdlConnect);
                $iLastServer = $key;

                return true;

            } catch (\SoapFault $e) {
                $arResultConnect[ $iRetryCounter ] = $e->getMessage();
            }

            if ($iRetryCounter >= $iRetryMax) {
                throw new ExceptionC("Connect log", $arResultConnect, 0);
            }
        } while ($arServerArray = $this->CycleArray());
    }

    public function Convert1CDateToTS($sDate) {
        return MakeTimeStamp($sDate, 'YYYY-MM-DD HH:MI:SS');
    }

    public function ConvertSiteDateToTS($sDate) {
        return MakeTimeStamp($sDate, CSite::GetDateFormat("FULL"));
    }

    public function ConvertTSTo1CDate($ts, $iTime = true) {
        return date('Y-m-d' . ($iNoTime ?  ' H:i:s' : ''), $ts);
    }
}
