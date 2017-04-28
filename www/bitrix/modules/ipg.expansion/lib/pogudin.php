<?
namespace IPG\Expansion;

Class Pogudin
{
	public $arLastError = array();

    final function GetCachedData($arParams, $iCacheTime = 3600, $sCacheDir = 'PogudinCache', $sCacheVersion = 'v1') {
        $obCache = new CPHPCache;
        $cache_id = md5(serialize($arParams) . $sCacheVersion);

        if($obCache->InitCache($iCacheTime, $cache_id, $sCacheDir)) {
            $arResult = $obCache->GetVars();
            $arResult['CACHED'] = 'Y';
        } else {
            $arResult = $this->GetData($arParams);
            $obCache->StartDataCache();
            $obCache->EndDataCache($arResult);
            $arResult['CACHED'] = 'N';
        }

        return $arResult;
    }

    public function GetData($arParams) {
        echo 'Need reinit GetData function from Class';
        return false;
    }

	public function log_array($array, $file = '/syslog.log', $prefix = 'log', $index = true) {
		$old_abort_status = ignore_user_abort(true);
		
		ob_start();
		print_r($array);
		$html = ob_get_contents();
		ob_end_clean();
		
		$file = $_SERVER["DOCUMENT_ROOT"] . $file;
		
		if ($fp = @fopen($file, "ab+")) {
			if (flock($fp, LOCK_EX)) {
				@fwrite($fp, date("Y-m-d H:i:s")." - ".$prefix."\n".$html."\n - - - - - - - - - - - - - - - - - - - - - - - - - \n\n");
				@fflush($fp);
				@flock($fp, LOCK_UN);
				@fclose($fp);
			}
		}
		
		if ($index) {
			$file .= '.index.log';
			
			if ($fp = @fopen($file, "ab+")) {
				if (flock($fp, LOCK_EX)) {
					@fwrite($fp, date("Y-m-d H:i:s")." - ".$prefix."\n");
					@fflush($fp);
					@flock($fp, LOCK_UN);
					@fclose($fp);
				}
			}
		}
		
		ignore_user_abort($old_abort_status);
	}
}
?>