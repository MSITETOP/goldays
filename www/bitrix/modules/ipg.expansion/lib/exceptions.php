<?
namespace IPG\Expansion;

Class ExceptionBase extends \Exception
{
    function Log() {
        echo "Log on ExceptionC<br />";
    }
}

Class ExceptionW extends ExceptionBase
{

}

Class ExceptionC extends ExceptionBase
{
    public function __construct($message = "", $arArrayLog = false, $code = 0, $previous = null) {
        // Логируем, шлем страшные письма и SMS!
        if ($arArrayLog !== false) {
            parent::Log($message, $arArrayLog);
            $message .= "\n" . print_r($arArrayLog, true);
        }

        // Передаем в стандартный обработчик
        parent::__construct($message, $code, $previous);
    }
}

Class ExceptionSoapC extends \SoapFault
{
    public function __construct($message = "", $code = 0, $previous = null) {
        // Передаем в Critical обработчик, так как Catch при экзепшне напрямую к ExceptionC не срабатывает
        //throw new ExceptionC($message, $code, $previous);
    }
}
