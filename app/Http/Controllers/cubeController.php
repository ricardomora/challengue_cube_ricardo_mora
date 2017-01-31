<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\SaveCubeRequest;
use App\Http\Requests;
use Validator;

class cubeController extends Controller {

	var $numOper;
    var $numtest;
    var $line;

    public function  __construct(){
		$this->numtest=0;
		$this->numOper=0;
		$this->line = array();
	}

    public function index() {

        return view('cube.index');
    }

    public function create(Request $request) {
        $line = explode("\r\n", $request['text-in']);

        foreach ($line as $valueArray) {
            $command = explode(" ", $valueArray);
            $this->line =$command;

            switch (count($command)) {
                case "1":
                    $t = $command[0];
                    $test = $this->imputValidator(1);
                    if ($test){ return $test ; };

                    break;
                case "2":

                    $n = $command[0];
                    $m = $command[1];
                    $this->numtest++;

                    $test = $this->imputValidator(2);
                    if ($test){ return $test ; };

                    break;
                case "5":
    						
                        $x = $command[1];
                        $y = $command[2];
                        $z = $command[3];
                        $value = $command[4];

                    $this->numOper++;
                    $test = $this->imputValidator(5,$n);
                    if ($test){ return $test ; };

              
                    break;
                case '7':
          
                        $x1 = $command[1];
                        $y1 = $command[2];
                        $z1 = $command[3];
                        $x2 = $command[4];
                        $y2 = $command[5];
                        $z2 = $command[6];

                    $this->numOper++;
                    $test = $this->imputValidator(7,$n,$x1,$y1,$z1,$x2,$y2,$z2);
                    if ($test){ return $test ; };

                    
                    break;
                default:

                    break;
            }
        }

        return view('cube.index');
    }


    private function createMatriz()
    {
       
    }

      private function imputValidator($opc,$n=0,$x1=0,$y1=0,$z1=0,$x2=0,$y2=0,$z2=0)
    {
    	$textrequest=new SaveCubeRequest();

    	$rules= $textrequest->rules($opc,$n,$x1,$y1,$z1,$x2,$y2,$z2);
	    $messages= $textrequest->messages($opc,$this->numtest,$this->numOper);
        $validator = Validator::make($this->line, $rules, $messages);

	    if ($validator->fails()) {
			$errors = $validator->errors();
			return redirect()->route('cube-index')->with('errors', $errors);
	    }

       	return false;
    }




}
