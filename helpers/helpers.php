<?php
/**
 * Хелперы
 */

namespace Helpers;

use App\Renderable;

function printArray($data) {
    echo "<pre style='  color: orange;  background-color: #000;'>";
    print_r($data);
    echo "</pre>";
}



/**
 * Функция возращает значение из массива $array с ключом $key вида "key1.key2.***.value"
 * @param array $array
 * @param $key
 * @param null $default
 * @return array|mixed|null
 */
function arrayGet(array $array, $key, $default = null ) {
    //  Текущий уровень
    $currentLevel =& $array;
    //  Разбиваем $key по точке на массив
    $levels = explode('.', $key);

    // Ищем в массиве $levels ключ, совпадающий с ключом в массиве $currentLevel
    foreach ($levels as $key) {
        // Если такой ключ есть и $currentLevel[$key] является массивом
        if (array_key_exists($key, $currentLevel) && is_array($currentLevel[$key])) {
            // $currentLevel становится ссылкой на $currentLevel[$key]
            $currentLevel =& $currentLevel[$key];
        } else {
            // Иначе, возвращает значение $currentLevel[$key] или значение по дефолту
            return ((empty($currentLevel[$key])) ? $default : $currentLevel[$key]);
        }
    }
    // возвращает значение $currentLevel или значение по дефолту
    return ((empty($currentLevel)) ? $default : $currentLevel);
}

/**
 * Функция возвращает View of Exception
 * @param \Exception $e
 */
function renderException(\Exception $e) {
    // Если экземпляр Renderable
    if ($e instanceof Renderable) {
        // то запускаем его метод render()
        $e->render();
    } else {
        // Иначе выводим сообщение исключения
        echo $e->getMessage();
    }
}

/**
 * Russian months names
 * @return array
 */
function getRusMonthsNamesArray() {
    return [1 => 'янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'];
}
