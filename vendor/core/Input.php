<?php

class Input
{
    protected $errors = [];
    protected $vars = [
        'POST' => [],
        'GET' => [],
        'COOKIE' => [],
        'SESSION' => []
    ];
    protected $currentMethod;
    protected $temp = [];
    protected $filters = [
        'string' => FILTER_SANITIZE_STRING,
        'number:int' => FILTER_SANITIZE_NUMBER_INT,
        'number:float' => FILTER_SANITIZE_NUMBER_FLOAT,
        'array:int' => [
            'filter' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'array:string' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'email' => FILTER_SANITIZE_EMAIL,
        'url' => FILTER_SANITIZE_URL
    ];

    public function __construct()
    {
        foreach ($this->vars as $var => $value) {
            switch ($var) {
                case 'POST': $this->trimVars($_POST); break;
                case 'GET': $this->trimVars($_GET); break;
                case 'COOKIE': $this->trimVars($_COOKIE); break;
                case 'SESSION': $this->trimVars($_SESSION); break;
            }
        }
    }

    /**
     * @param $request_method
     * @param array $options
     * @return $this
     * @throws Exception
     * -------------------------------------------------------------------
     */
    public function filter($request_method, array $options = [])
    {
        if (!isset($options)) {
            throw new Exception('Ошибка. Не определёны параметры фильтрации.');
        }
        $request_method = strtoupper($request_method);
        if (!array_key_exists($request_method, $this->vars)) {
            throw new Exception("Ошибка. Суперглобального массива {$request_method} нет.");
        }

        foreach ($options as $var => $filter) {
            if (array_key_exists($filter, $this->filters)) {
                $this->temp[$var] = $this->filters[$filter];
            }
        }

        $request_constant = intval("INPUT_{$request_method}");
        $this->vars[$request_method] = filter_input_array($request_constant, $this->temp, $add_empty = true);
        $this->currentMethod = $request_method;
        return $this;
    }

    /**
     * @param array $options
     * -------------------------------------------------------------------
     */
    public function getErrors(array $options = [])
    {
        foreach ($this->vars[$this->currentMethod] as $key => $value) {
            if (!array_key_exists($key, $options)) {
                continue;
            }
            if (empty($value)) {
                $this->errors[] = $options[$key];
            }
        }
        return $this->errors;
    }

    /**
     * @param null $var
     * @return mixed
     * -------------------------------------------------------------------
     */
    public function post($var = null)
    {
        if (!isset($this->vars['POST'][$var])) {
            return $this->vars['POST'];
        }
        return $this->vars['POST'][$var];
    }

    /**
     * @param array $vars
     * -------------------------------------------------------------------
     */
    public function trimVars(array &$vars)
    {
        foreach ($vars as $var => $value) {
            $vars[$var] = trim($value, ' ');
        }
    }
}