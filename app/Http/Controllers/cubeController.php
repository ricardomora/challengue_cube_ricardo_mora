<?php

namespace App\Http\Controllers;

use App\Cube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SaveCubeRequest;
use App\Http\Requests;
use Validator;

class cubeController extends Controller {

    var $numOper;
    var $numtest;
    var $line;
    var $cube;
    var $result;
    var $n;
    var $m;

    public function __construct() {
        $this->numtest = 0;
        $this->numOper = 0;
        $this->line = array();

        $this->n = 0;
        $this->m = 0;

        $this->cube = new Cube();
        $this->result = array();
    }

    public function index() {

        return view('cube.index', array('result' => null));
    }

    public function show() {

        return view('cube.result');
    }

    public function store(Request $request) {
        $line = explode("\r\n", $request['text-in']);
        $t = 0;

        foreach ($line as $valueArray) {
            $command = explode(" ", $valueArray);
            $this->line = $command;

            switch (count($command)) {
                case "1":
                    if ($t == 0) {
                        $t = $command[0];
                        $test = $this->imputValidator(1);
                        if ($test) {
                            return $test;
                        };
                    }
                    break;
                case "2":

                    $this->n = $command[0];
                    $this->m = $command[1];

                    $this->numtest++;
                    $this->numOper = 0;

                    $test = $this->imputValidator(2);
                    if ($test) {
                        return $test;
                    } else {
                        $this->cube->inicializarCube($this->n);
                    };

                    break;
                case "5":

                    if ($this->numOper < $this->m) {
                        $x = $command[1];
                        $y = $command[2];
                        $z = $command[3];
                        $value = $command[4];
                        $this->numOper++;

                        $test = $this->imputValidator(5, $this->n);
                        if ($test) {
                            return $test;
                        } else {
                            $this->cube->updateBloque($x, $y, $z, $value);
                        }
                    }

                    break;
                case '7':
                    if ($this->numOper < $this->m) {
                        $x1 = $command[1];
                        $y1 = $command[2];
                        $z1 = $command[3];
                        $x2 = $command[4];
                        $y2 = $command[5];
                        $z2 = $command[6];

                        $this->numOper++;
                        $test = $this->imputValidator(7, $this->n, $x1, $y1, $z1, $x2, $y2, $z2);
                        if ($test) {
                            return $test;
                        } else {
                            $query = $this->cube->sumatoria($x1, $y1, $z1, $x2, $y2, $z2);
                            array_push($this->result, "QUERY $x1 $y1 $z1 $x2 $y2 $z2 = " . $query);
                        }
                    }
                    break;
                default:
                    $this->line = array();
                    $messages = ['required' => 'Error. Unknown command'];
                    $validator = Validator::make($this->line, ['required',], $messages);
                    if ($validator->fails()) {
                        $errors = $validator->errors();
                        return redirect()->route('cube-index')->with('errors', $errors);
                    }

                    break;
            }
        }

        if ($this->numOper < $this->m) {
            $this->numOper++;
            $this->line = array();

            $messages = ['required' => 'Error. Operation required, testcase #' . $this->numtest . ' - operation ' . $this->numOper,];
            $validator = Validator::make($this->line, ['required',], $messages);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->route('cube-index')->with('errors', $errors);
            }
        }

        if ($this->numtest < $t) {
            $this->numtest++;
            $this->line = array();

            $messages = ['required' => 'Error. testcase required  #' . $this->numtest];
            $validator = Validator::make($this->line, ['required',], $messages);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->route('cube-index')->with('errors', $errors);
            }
        }

        return view('cube.index', [ 'result' => $this->result, 'textold' => $request['text-in']]);
    }

    private function createMatriz() {
        
    }

    private function imputValidator($opc, $n = 0, $x1 = 0, $y1 = 0, $z1 = 0, $x2 = 0, $y2 = 0, $z2 = 0) {
        $textrequest = new SaveCubeRequest();

        $rules = $textrequest->rules($opc, $n, $x1, $y1, $z1, $x2, $y2, $z2);
        $messages = $textrequest->messages($opc, $this->numtest, $this->numOper);
        $validator = Validator::make($this->line, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('cube-index')->with('errors', $errors);
        }

        return false;
    }

}
