<?php
/**
 * Класс View
 */

namespace App;

use App\Renderable as Renderable;
use Exception;
use Twig\Loader\FilesystemLoader;
use Twig\Environment as Twig_Environment;
use Twig\Extension\DebugExtension as Twig_Extension_Debug;

/**
 * Class View
 * @package App
 */
class View implements Renderable
{
    private $view;
    private $parameters;

    /**
     * View constructor.
     * @param string $view
     * @param array $parameters
     */
    public function __construct(string $view, array $parameters = [])
    {
        // Преобразуем параметр $view в путь до нужного шаблона

        $this->view = strtolower(str_replace('.','/',$view)) . ".html.twig";

        $this->parameters = $parameters;
    }

    /**
     * @return bool|mixed
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render()
    {

        if(file_exists( VIEW_DIR . DIRECTORY_SEPARATOR . $this->view)) {

            //APP_DIR . DIRECTORY_SEPARATOR . VIEW_DIR . DIRECTORY_SEPARATOR
            $loader = new FilesystemLoader(VIEW_DIR );

            //printArray(APP_DIR . DIRECTORY_SEPARATOR . VIEW_DIR . DIRECTORY_SEPARATOR );

            $twig = new Twig_Environment($loader, [
                'debug' => true,
                //'cache' => $_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'tmp',
            ]);

            $twig->addExtension(new Twig_Extension_Debug);

            echo $twig->render($this->view, $this->parameters);
        } else {
            echo "Данного шаблона не существует";
            return false;
        }
    }
    public function getParameters()
    {
        return $this->parameters;
    }

}
