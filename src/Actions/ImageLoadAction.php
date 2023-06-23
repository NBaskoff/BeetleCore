<?php

namespace BeetleCore\Actions;

use Intervention\Image\ImageManager;

class ImageLoadAction
{
    public function __invoke()
    {
        if (!empty($_FILES["file"]["tmp_name"])) {
            $file = request("file");
            $md5 = md5_file($file->getPathname());
            $ext = $file->extension();
            $fileName = public_path() . "/files/$md5.$ext";
            $name = $file->hashName();
            move_uploaded_file($file->getPathname(), $fileName);

            $manager = new ImageManager(["driver" => "imagick"]);
            $img = $manager->make($fileName);

            $img = $img->resize(request("width"), null, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($img->height() < request("height")) {
                $img = $img->resize(null, request("height"), function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            /*$img = $img->resize(request("width"), request("height"), function ($constraint) {
                $constraint->aspectRatio();
            });*/

            $info = [
                "file" => "/files/$md5.$ext",
                "name" => $_FILES["file"]["name"],
            ];

            $img = $manager->canvas(request("width"), request("height"))
                ->insert($img, "center-center")
                ->save(public_path() . "/files/{$md5}_tmp.png", 100);
            $info["img"] = $this->saveFile("/files/{$md5}_tmp.png");

            $img->resize("300", null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path() . "/files/{$md5}_tmp.png", 100);
            $info["small"] = $this->saveFile("/files/{$md5}_tmp.png");

            $field = request("field");
            return view("beetlecore::fields.image_box_load", compact("info", "field"))->toHtml();
        }
    }

    protected function saveFile($path)
    {
        $md5Img = md5_file(public_path() . $path);
        copy(public_path() . $path, public_path() . "/files/{$md5Img}.png");
        unlink(public_path() . $path);
        return "/files/{$md5Img}.png";
    }
}
