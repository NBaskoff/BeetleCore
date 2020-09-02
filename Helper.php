<?php


namespace BeetleCore;


class Helper
{
    public static function translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = strip_tags($s); // убираем HTML-теги
        $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
        $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
        $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
        return $s; // возвращаем результат
    }

    static public function strip_html_tags($str)
    {
        $str = preg_replace('/(<|>)\1{2}/is', '', $str);
        $str = preg_replace(
            array(// Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
            ), "", //replace above with nothing
            $str);
        $str = self::replaceWhitespace($str);
        $str = strip_tags($str);
        return html_entity_decode($str, ENT_NOQUOTES, 'utf-8');
    }

    //function strip_html_tags ENDS
    //To replace all types of whitespace with a single space
    static protected function replaceWhitespace($str)
    {
        $result = $str;
        foreach (array(
                     "  ", " \t", " \r", " \n",
                     "\t\t", "\t ", "\t\r", "\t\n",
                     "\r\r", "\r ", "\r\t", "\r\n",
                     "\n\n", "\n ", "\n\t", "\n\r",
                 ) as $replacement) {
            $result = str_replace($replacement, $replacement[0], $result);
        }
        return $str !== $result ? self::replaceWhitespace($result) : $result;
    }

    /**
     * @param array $telegrammText
     */
    public static function sendTelegramMessage($telegrammText)
    {
        $token = "token";
        $chat_id = "id";
        if (!empty($telegrammText))
            foreach ($telegrammText as $k => $i) {
                $telegrammText[$k] = urlencode($i);
            }
        $telegrammText = implode("%0A", $telegrammText);

        $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id=$chat_id&parse_mode=html&text=$telegrammText";
        $ch = curl_init(); // инициализация
        curl_setopt($ch, CURLOPT_URL, $url); // адрес страницы для скачивания
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);   //TIMEOUT
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //Переходим по редиректам
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // нам нужно вывести загруженную страницу в переменную
        curl_setopt($ch, CURLOPT_PROXY, "196.19.122.67:8000");
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "1k0xL9:qbw3Lr");
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
        curl_exec($ch);
        curl_close($ch);
    }

    public static function getUrl($url)
    {
        $ch = curl_init(); // инициализация
        curl_setopt($ch, CURLOPT_URL, $url); // адрес страницы для скачивания
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);   //TIMEOUT
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  //Переходим по редиректам
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // нам нужно вывести загруженную страницу в переменную
        //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }
}
