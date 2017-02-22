<?php
namespace vendor\core\exceptions;

class BaseException extends \Exception
{
    /**
     * @param bool $withNamespace
     * @return bool|string
     * -----------------------------------------------------------------------------
     */
    public function getHeader($withNamespace = true)
    {
        if ($withNamespace || strpos(get_class($this), '\\') == false) {
            return get_class($this);
        }
        if (strpos(get_class($this), '\\')) {
            $lastSlashPosition = strrpos(get_class($this), '\\');
            $lastPathPart = substr(get_class($this), $lastSlashPosition + 1);
            return $lastPathPart;
        }
        return false;
    }

    /**
     * @return string
     * -----------------------------------------------------------------------------
     */
    public function getFilename()
    {
        $lastSlashPosition = strrpos($this->getFile(), DIRECTORY_SEPARATOR);
        $lastPathPart = substr($this->getFile(), $lastSlashPosition + 1);
        return $lastPathPart;
    }

    /**
     * @return array
     * -----------------------------------------------------------------------------
     */
    public function traces()
    {
        $traceStringsArray = [];
        $traceString = '';
        $traceArgs = '';
        $tracesCounter = 1;
        $argsCounter = 0;

        foreach ($this->getTrace() as $traceItem) {

            if (empty($traceItem['class'])) {
                $traceItem['class'] = '';
                $traceItem['type'] = '';
            }

            $countArgs = count($traceItem['args']);
            $traceString .= "{$tracesCounter}. {$traceItem['file']} ({$traceItem['line']}): ";
            $traceString .= "{$traceItem['class']}{$traceItem['type']}";
            foreach ($traceItem['args'] as $arg) {
                switch (true) {
                    case is_bool($arg):
                        $traceArgs .= ($arg == true) ? 'true' : 'false';
                        break;
                    case is_array($arg):
                        $traceArgs .= '[Array]';
                        break;
                    case is_string($arg):
                        $traceArgs .= "'{$arg}'";
                        break;
                    default:
                        $traceArgs .= '';
                        break;
                }
                $traceArgs .= ($countArgs > 1 && $countArgs - 1 != $argsCounter) ? ", " : "";
                $argsCounter++;
            }
            $traceString .= "{$traceItem['function']}({$traceArgs})";
            $traceStringsArray[] = $traceString;
            $traceString = '';
            $traceArgs = '';
            $tracesCounter++;
        }
        return $traceStringsArray;
    }

    /**
     * -----------------------------------------------------------------------------
     */
    public function errorMessage()
    {
        require LOCAL_VIEWS_DIR . _DS_ . "exception.view.php";
    }
}