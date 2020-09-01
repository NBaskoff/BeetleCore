<?php
namespace BeetleCore;

use WideImage\WideImage;
use const FDROOT;

class Image
{

    public $settings = array();
    public $file = null;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    static function image($settings)
    {
        $class = self::class;
        $class = new $class($settings);
        $image = $class->run();
        $extra = '';
        $noextra = array("width", "height", "src", "file");
        foreach ($settings as $k => $i) {
            if (!in_array($k, $noextra)) {
                $extra .= ' ' . $k . '="' . $i . '"';
            }
        }
        if ($image['result'] === false) {
            return implode($image['error'], "<br>");
        } else {
            return '<img src="' . $image['result']['file_name'] . '" "' . $extra . '/>';
        }
    }

    static function link($settings)
    {
        $class = self::class;
        $class = new $class($settings);

        $image = $class->run();
        if ($image['result'] === false) {
            return implode($image['error'], "<br>");
        } else {
            return $image['result']['file_name'];
        }
    }

    function run()
    {
        $error = array();
        /*if (!file_exists($DROOT . "/var/image_cache/")) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . "/var/image_cache/", 0777, true);
        }*/
        //перед началом каких-либо работ проверим наличие фала
        if ((!file_exists(FDROOT . $this->settings['file'])) OR (empty($this->settings['file']))) {
            $error[] = "Файл '" . FDROOT . $this->settings['file'] . "' не найден";
        } else {
            //составим имя файла
            $file_name = $this->createFileName();
            $file_name = "/images/" . $file_name;
            //Проверим закешированный
            if (!file_exists(FDROOT . $file_name)) {
                $this->file = WideImage::load(FDROOT . $this->settings['file']);
                //Определим последовательность действиий
                $action = $this->conveyor();
                //Выполним их
                if (!empty($action))
                    foreach ($action as $k => $i) {
                        $this->$i();
                    }
                //сохраним файлик
                imageinterlace($this->file->getHandle(), 1);
                $this->file->saveToFile(FDROOT . $file_name);
            }
            if (!empty($error)) {
                $result = false;
            } else {
                /*if (empty($this->file)) {
                    $this->file = WideImage::load($DROOT . $file_name);
                }
                $width = $this->file->getWidth();
                $height = $this->file->getHeight();*/
                $result = array('file_name' => $file_name);
            }
            return array('result' => $result, 'error' => $error);
        }
    }

    private function createFileName()
    {
        $fileName = array();
        $DROOT = $_SERVER["DOCUMENT_ROOT"];
        $fileName[] = md5_file($DROOT . $this->settings['file']);

        $fileName[] = str_replace("/", "_", $this->settings['file']);
        if (!empty($this->settings['width'])) {//ширина
            $fileName[] = "wi" . $this->settings['width'];
        }
        if (!empty($this->settings['height'])) {//высота
            $fileName[] = "he" . $this->settings['height'];
        }
        if (!empty($this->settings['type'])) {//высота
            $fileName[] = "ty" . $this->settings['type'];
        }

        if (!empty($this->settings['max_width'])) {//максимальная ширина
            $fileName[] = "maw" . $this->settings['max_width'];
        }
        if (!empty($this->settings['max_height'])) {//максимальная высота
            $fileName[] = "mah" . $this->settings['max_height'];
        }
        if (!empty($this->settings['min_width'])) {//максимальная ширина
            $fileName[] = "miw" . $this->settings['min_width'];
        }
        if (!empty($this->settings['min_height'])) {//максимальная высота
            $fileName[] = "mih" . $this->settings['min_height'];
        }
        if (!empty($this->settings['alpha'])) {//Файл альфы
            $fileName[] = "al";
            $fileName = array_merge($fileName, explode("/", $this->settings['alpha']));
        }
        if (!empty($this->settings['watermarks'])) {//Файл водного знака
            $fileName[] = "wa" . str_replace("/", "_", $this->settings['watermarks']);
        }
        if (!empty($this->settings['background'])) {//цвет заливки "пустого" места. если задан то альфа ноложится на уже "залитую" картинку
            $fileName[] = "ba" . str_replace("#", "", $this->settings['background']);
        }
        /*$fileName = array_merge($fileName, explode("/", $this->settings['file']));
        if ((!empty($this->settings['alpha'])) OR ( !empty($this->settings['width']) AND ! empty($this->settings['height'])
                AND ! empty($this->settings['type']) AND ( $this->settings['type'] == "in"))
        ) {
            $fileName[] = ;
        }*/
        return implode("_", $fileName) . ".png";
    }

    private function conveyor()
    {
        $action = array();
        $resizeCanvas = false;
        //Для начала определимся с размером
        if (!empty($this->settings["width"]) AND !empty($this->settings["height"])) {
            $action[] = "widthHeight";
            if ($this->settings['type'] == "in") {
                $resizeCanvas = true;
            }
        } elseif (!empty($this->settings["width"])) {
            $action[] = "width";
        } elseif (!empty($this->settings["height"])) {
            $action[] = "height";
        } elseif (!empty($this->settings["max_width"]) AND !empty($this->settings["max_height"])) {
            $action[] = "widthHeightMax";
        } elseif (!empty($this->settings["max_width"])) {
            $action[] = "widthMax";
        } elseif (!empty($this->settings["max_height"])) {
            $action[] = "heightMax";
        } elseif (!empty($this->settings["min_width"]) AND !empty($this->settings["min_height"])) {
            $action[] = "widthHeightMin";
        } elseif (!empty($this->settings["min_width"])) {
            $action[] = "widthMin";
        } elseif (!empty($this->settings["min_height"])) {
            $action[] = "heightMin";
        }
        //последовательность наложения альфы и водного знака зависит от того, задан бекграунд или нет
        if (!empty($this->settings["background"])) {
            if ($resizeCanvas) {
                $action[] = "resizeCanvas";
            }
            if (!empty($this->settings["alpha"])) {
                $action[] = "alpha";
            }
            if (!empty($this->settings["watermarks"])) {
                $action[] = "watermarks";
            }
        } else {
            if (!empty($this->settings["alpha"])) {
                $action[] = "alpha";
            }
            if (!empty($this->settings["watermarks"])) {
                $action[] = "watermarks";
            }
            if ($resizeCanvas) {
                $action[] = "resizeCanvas";
            }
        }
        return $action;
    }

    private function widthHeight()
    {
        if (empty($this->settings['type'])) {
            $this->file = $this->file->resize($this->settings['width'], $this->settings['height'], 'fill');
        } elseif ($this->settings['type'] == "in") {//Картинка внутри размера
            $width = $this->file->getWidth();
            $height = $this->file->getHeight();
            //Узнаем какой из них ближе к нужному
            $tW = $width / $this->settings['width'];
            $tH = $height / $this->settings['height'];
            if ($tW > $tH) {
                $this->file = $this->file->resize($this->settings['width'], null, 'fill');
            } else {
                $this->file = $this->file->resize(null, $this->settings['height'], 'fill');
            }
            $this->resizeCanvas();
        } elseif ($this->settings['type'] == "out") {//Картинка за пределами размера
            $width = $this->file->getWidth();
            $height = $this->file->getHeight();
            //Узнаем какой из них ближе к нужному
            $tW = $width / $this->settings['width'];
            $tH = $height / $this->settings['height'];
            if ($tW < $tH) {
                $this->file = $this->file->resize($this->settings['width'], null, 'fill');
            } else {
                $this->file = $this->file->resize(null, $this->settings['height'], 'fill');
            }
            $this->resizeCanvas();
        }
    }

    private function width()
    {
        $this->file = $this->file->resize($this->settings['width'], null, 'fill');
    }

    private function height()
    {
        $this->file = $this->file->resize(null, $this->settings['height'], 'fill');
    }

    private function widthHeightMax()
    {
        $width = $this->file->getWidth();
        $height = $this->file->getHeight();
        if ($width > $this->settings['max_width']) {
            $this->file = $this->file->resize($this->settings['max_width'], null, 'fill');
        }
        if ($height > $this->settings['max_height']) {
            $this->file = $this->file->resize(null, $this->settings['max_height'], 'fill');
        }
    }

    private function widthMax()
    {
        $width = $this->file->getWidth();
        if ($width > $this->settings['max_width']) {
            $this->file = $this->file->resize($this->settings['max_width'], null, 'fill');
        }
    }

    private function heightMax()
    {
        $height = $this->file->getHeight();
        if ($height > $this->settings['max_height']) {
            $this->file = $this->file->resize(null, $this->settings['max_height'], 'fill');
        }
    }

    private function widthHeightMin()
    {

    }

    private function widthMin()
    {

    }

    private function heightMin()
    {

    }

    private function resizeCanvas()
    {
        if (!empty($this->settings['background'])) {
            $bg = $this->settings['background'];
            $this->file = $this->file->resizeCanvas($this->settings['width'], $this->settings['height'], 'center', 'center', $this->file->allocateColor(hexdec($bg[1] . $bg[2]), hexdec($bg[3] . $bg[4]), hexdec($bg[5] . $bg[6])));
        } else {
            $this->file = $this->file->resizeCanvas($this->settings['width'], $this->settings['height'], 'center', 'center');
        }
    }

    private function alpha()
    {
        $alpha = WideImage::loadFromFile($_SERVER["DOCUMENT_ROOT"] . $this->settings['alpha']);
        $this->file = $this->file->applyMask($alpha, 0, 0);
    }

    private function watermarks()
    {

    }

}
