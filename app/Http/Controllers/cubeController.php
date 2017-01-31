<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cubeController extends Controller {

    public function index() {

        return view('cube.index');
    }

    public function create(Request $request) {
        $line = explode("\r\n", $request['text-in']);

        foreach ($line as $valueArray) {
            $command = explode(" ", $valueArray);

            switch (count($command)) {
                case "1":
                    $t = $command[0];
                    break;
                case "2":
                    $n = $command[0];
                    $m = $command[1];
                    break;
                case "5":
                    if ($command[0] !== 'UPDATE') {
                        $message = "Error UPDATE command";
                    } else {
                        $x = $command[1];
                        $y = $command[2];
                        $z = $command[3];
                        $value = $command[4];
                    }
                    break;
                case '7':
                    if ($command[0] !== 'QUERY') {
                        $message = "Error QUERY command";
                    } else {

                        $x1 = $command[1];
                        $y1 = $command[2];
                        $z1 = $command[3];
                        $x2 = $command[4];
                        $y2 = $command[5];
                        $z2 = $command[6];
                    }
                    break;
                default:
                    $message = "Error command";
                    break;
            }
        }

        return view('cube.index');
    }

}
