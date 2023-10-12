<?php

namespace BeetleCore\Actions;

class FileLoadAction
{
    public function __invoke() {
        $value = [];
        if (request()->hasFile("file")) {
            $file = request()->file("file");
            $value = [
                "name" => $file->getClientOriginalName(),
                "ext" => $file->getClientOriginalExtension(),
                "path" => $file->store("public/catalog"),
            ];
        }
        return $value;
    }
}
