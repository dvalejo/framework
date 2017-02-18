<?php
namespace vendor\core\base;

class View
{
    protected $view;
    protected $layout;

    /**
     * View constructor.
     * @param $view
     * @param $layout
     * -------------------------------------------------------------------
     */
    public function __construct($view, $layout)
    {
        $this->layout = $layout;
        $this->view = $view;
    }

    /**
     * @param $vars
     * -------------------------------------------------------------------
     */
    public function render($vars)
    {
        ob_start(); // Помещаем вывод в буфер обмена
        extract($vars);
        $fullView = LOCAL_VIEWS_DIR . _DS_ . $this->view . '.view.php';
        if (!file_exists($fullView)) {
            echo 'Вид не найден <br>';
            exit();
        }
        require $fullView;
        $content = ob_get_clean(); // Присваиваем данные из буфера обмена переменной

        $fullLayout = LOCAL_VIEWS_DIR . _DS_ . 'layouts/' . $this->layout . '.php';
        if (!file_exists($fullLayout)) {
            echo 'Шаблон не найден <br>';
            exit();
        }
        require $fullLayout;
    }
}