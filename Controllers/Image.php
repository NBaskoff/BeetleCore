<?php


namespace BeetleCore\Controllers;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic;

class Image
{
    public function load()
    {
        if (!empty($_FILES["file"]["tmp_name"])) {
            $file = request("file");
            $md5 = md5_file($file->getPathname());
            $ext = $file->extension();
            $fileName = public_path() . "/files/$md5.$ext";
            $name = $file->hashName();
            move_uploaded_file($file->getPathname(), $fileName);

            $img = ImageManagerStatic::make($fileName);

            if (($img->width() / request("width")) < ($img->height() / request("height"))) {
                //> - Картинка внутри размера
                //< - Картинка за пределами размера
                $img = $img->resize(request("width"), null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            } else {
                $img = $img->resize(null, request("height"), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            $info = [
                "file" => "/files/$md5.$ext",
                "name" => $_FILES["file"]["name"],
            ];

            $img = ImageManagerStatic::canvas(request("width"), request("height"))
                ->insert($img, "center-center")
                ->save( public_path() . "/files/{$md5}_tmp.png");
            $md5Img = md5_file(public_path() . "/files/{$md5}_tmp.png");
            copy(public_path() . "/files/{$md5}_tmp.png", public_path() . "/files/{$md5Img}.png");
            unlink(public_path() . "/files/{$md5}_tmp.png");
            $info["img"]  = "/files/{$md5Img}.png";

            $img->resize("300", null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save( public_path() . "/files/{$md5}_tmp.png");
            $md5Img = md5_file(public_path() . "/files/{$md5}_tmp.png");
            copy(public_path() . "/files/{$md5}_tmp.png", public_path() . "/files/{$md5Img}.png");
            unlink(public_path() . "/files/{$md5}_tmp.png");
            $info["small"]  = "/files/{$md5Img}.png";

            $field = request("field");
            return view("beetlecore::fields.image_box_load", compact( "info", "field"))->toHtml();
        }
    }

    public function size()
    {
        $params = request()->all();
        $x = (int)$params["x"];
        $y = (int)$params["y"];
        $width = (int)$params["width"];
        $height = (int)$params["height"];
        $widthX = $x + $width;
        $hightY = $y + $height;

        $fileName = public_path() . request("file");

        $img = ImageManagerStatic::make($fileName);

        $img = $img->rotate(-(int)$params["rotate"]);

        $canvasSize = $params["canvas"];
        $imageSize = [$img->width(), $img->height()];

        $fileSave = public_path() . "/files/tmp.png";
        @unlink($fileSave);

        if ($x >= 0 AND $y >= 0 AND $imageSize[0] >= $widthX AND $imageSize[1] >= $hightY) {
            //Начнём с самого простого - исходное изображение больше чем надо
            $img = $img->crop($width, $height, $x, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", 0, 0)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y < 0 AND $imageSize[0] < $widthX AND $imageSize[1] < $hightY) {
            //Не вмещается ничего - резать нечего, прсото встаавить со смещением
            //$img = $img->crop($imageSize[0], $imageSize[1], 0, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y >= 0 AND $imageSize[0] < $widthX AND $imageSize[1] >= $hightY) {
            //Не прошла правая сторона, остальные нормально
            $img = $img->crop($imageSize[0] - $x, (int)$params["height"], $x, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);

        } elseif ($x >= 0 AND $y >= 0 AND $imageSize[0] < $widthX AND $imageSize[1] < $hightY) {
            //Не прошла правая сторона и нижняя
            $img = $img->crop($imageSize[0] - $x, $imageSize[1] - $y, $x, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y >= 0 AND $imageSize[0] < $widthX AND $imageSize[1] < $hightY) {
            //Не прошла правая сторона и нижняя и левая
            $img = $img->crop($imageSize[0], $imageSize[1] - $y, 0, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y >= 0 AND $imageSize[0] >= $widthX AND $imageSize[1] < $hightY) {
            //Не прошла левая сторона и нижняя
            $img = $img->crop($imageSize[0] - $x, $imageSize[1] - $y, 0, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y >= 0 AND $imageSize[0] >= $widthX AND $imageSize[1] >= $hightY) {
            //Не прошла левая сторона
            $img = $img->crop($imageSize[0], $imageSize[1], 0, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y < 0 AND $imageSize[0] >= $widthX AND $imageSize[1] >= $hightY) {
            //Не прошла левая сторона и верхняя
            $img = $img->crop($imageSize[0] - $x, $imageSize[1] - $y, 0, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y < 0 AND $imageSize[0] < $widthX AND $imageSize[1] >= $hightY) {
            //Не прошла левая сторона и верхняя и правая
            $img = $img->crop($imageSize[0], $imageSize[1] - $y, 0, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y < 0 AND $imageSize[0] < $widthX AND $imageSize[1] >= $hightY) {
            //Не прошла верхняя и правая
            $img = $img->crop($imageSize[0] - $x, $imageSize[1] - $y, $x, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", 0, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y >= 0 AND $imageSize[0] < $widthX AND $imageSize[1] >= $hightY) {
            //Не вмещается левая и правая
            $img = $img->crop($imageSize[0], $height, 0, $y);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, 0)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y < 0 AND $imageSize[0] >= $widthX AND $imageSize[1] < $hightY) {
            //Не вмещается верх и низ
            $img = $img->crop($width, $imageSize[1], $x, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", 0, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y >= 0 AND $imageSize[0] >= $widthX AND $imageSize[1] < $hightY) {
            //Не вмещается низ
            $img = $img->crop($width, $imageSize[1], $x, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", 0, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y < 0 AND $imageSize[0] < $widthX AND $imageSize[1] < $hightY) {
            //Не вмещается верх право низ
            $img = $img->crop($imageSize[0] - $x, $imageSize[1], $x, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", 0, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x < 0 AND $y < 0 AND $imageSize[0] >= $widthX AND $imageSize[1] < $hightY) {
            //Не вмещается верх лево низ
            $img = $img->crop($imageSize[0] - $x, $imageSize[1], 0, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        } elseif ($x >= 0 AND $y < 0 AND $imageSize[0] >= $widthX AND $imageSize[1] >= $hightY) {
            //Не вмещается верх
            $img = $img->crop($imageSize[0] - $x, $imageSize[1], $x, 0);
            $img = ImageManagerStatic::canvas($width, $height)
                ->insert($img, "top-left", $x * -1, $y * -1)
                ->resize($canvasSize[0], $canvasSize[1])
                ->save($fileSave);
        }
        $info = [
            "file" => request("file"),
            "name" => request("name"),
        ];

        $md5Img = md5_file(public_path() . "/files/tmp.png");
        copy(public_path() . "/files/tmp.png", public_path() . "/files/{$md5Img}.png");
        unlink(public_path() . "/files/tmp.png");
        $info["img"]  = "/files/{$md5Img}.png";

        $img->resize("300", null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save( public_path() . "/files/tmp.png");
        $md5Img = md5_file(public_path() . "/files/tmp.png");
        copy(public_path() . "/files/tmp.png", public_path() . "/files/{$md5Img}.png");
        unlink(public_path() . "/files/tmp.png");
        $info["small"]  = "/files/{$md5Img}.png";

        $field = request("field");
        return view("beetlecore::fields.image_box_load", compact( "info", "field"))->toHtml();
    }
}
