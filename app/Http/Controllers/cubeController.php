<?php

namespace App\Http\Controllers;

use App\Cube;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\SaveCubeRequest;
use App\Http\Requests;
use Validator;

class cubeController extends Controller {

    var $n;
    var $m;
    var $t;

    var $cube;
    var $result;



    public function __construct() {
        $this->n = 0;
        $this->m = 0;
        $this->t = 0;

        $this->cube = new Cube();
        $this->result = array();
    }

    public function index() {

        return view('cube.index', array('result' => null));
    }

    public function store(Request $request) {
     
        $data = $request['text-in'];
        $data = preg_replace('/\r\n/', "\n", $data);
        $data = preg_replace('/\r/', "\n", $data);
        $line = explode("\n", $data);
     
        $numLine = 0;
        $command = explode(" ", $line[$numLine]);

        $numTotalTest = $command[0];
        $typeCommand = \Config::get('constants.command.create_test');
       
        $res= $this->validateLineByType($command, $typeCommand);
        if (!empty($res)) { return $res; }

        for ($numTest=1; $numTest <= $numTotalTest ; $numTest++) {
            $numLine++;
            
            if (isset($line[$numLine])){
                $command = explode(" ", $line[$numLine]);
                $typeCommand = \Config::get('constants.command.create_cube');

                if (count($command) == $typeCommand){
                    
                    $res= $this->createCube($command);
                    if (!empty($res)) { return $res; } 
                    
                    for ($numOpe=1; $numOpe <= $this->m ; $numOpe++) { 
                        $numLine++;
                        
                        if (isset($line[$numLine])){
                            $command = explode(" ", $line[$numLine]);
                            $typeUpdate = \Config::get('constants.command.update'); 
                            $typeQuery = \Config::get('constants.command.query'); 

                            if(count($command) ==  $typeUpdate || count($command) == $typeQuery ){
                                
                                if(count($command) ==  $typeUpdate){
                                    $res = $this->commandUpdate($command , $numTest , $numOpe );
                                }

                                if(count($command) == $typeQuery){
                                    $res = $this->commandQuery($command ,  $numTest , $numOpe );
                                }

                                if (!empty($res)) { return $res; } 

                            }else{
                                $message = 'Error. Unknown command Line #'. $numLine . ' review format query or update';
                                $res = $this->manualError($message);
                                if (!empty($res)) { return $res; } 
                            }

                        }else{
                            $message = 'Error. Line #'. ($numLine + 1 ) . ' you must enter Query or Update test case #'. $numTest . ' operation #'. $numOpe;
                            $res = $this->manualError($message);
                            if (!empty($res)) { return $res; }
                        }
                    }
                }else{
                    $message = 'Error. Line #'. $numLine . ' review format N y M';
                    $res = $this->manualError($message);
                    if (!empty($res)) { return $res; }
                }
            }else{
                $message = 'Error. line #' . ($numLine + 1 ) . ' you must enter N M values test case #'. $numTest;
                $res = $this->manualError($message);
                if (!empty($res)) { return $res; }
            }
        }


        return view('cube.index', [ 'result' => $this->result, 'textold' => $request['text-in']]);
    }

    private function createCube(array $command) {

        $this->n = $command[0];
        $this->m = $command[1];

        $typeCommand = \Config::get('constants.command.create_cube');
        $test = $this->validateLineByType($command, $typeCommand);
      
        if ($test) {
            return $test;
        } else {
            $this->cube->inicializarCube($this->n);
        };
        return null;
    }

    private function commandUpdate(array $command, $numTest , $numOpe) {


            $x = $command[1];
            $y = $command[2];
            $z = $command[3];
            $value = $command[4];

            $typeCommand = \Config::get('constants.command.update');
            $test = $this->validateLineByType($command, $typeCommand, $numTest , $numOpe, $this->n);
            if ($test) {
                return $test;
            } else {
                $this->cube->updateBloque($x, $y, $z, $value);
            }
        
        return null;
    }

    private function commandQuery(array $command, $numTest , $numOpe) {
   
     
            $x1 = $command[1];
            $y1 = $command[2];
            $z1 = $command[3];
            $x2 = $command[4];
            $y2 = $command[5];
            $z2 = $command[6];

            $typeCommand = \Config::get('constants.command.query');

            $test = $this->validateLineByType($command, $typeCommand, $numTest , $numOpe, $this->n, $x1, $y1, $z1, $x2, $y2, $z2);
            if ($test) {
                return $test;
            } else {
                $query = $this->cube->sumatoria($x1, $y1, $z1, $x2, $y2, $z2);
                array_push($this->result, "QUERY $x1 $y1 $z1 $x2 $y2 $z2 = " . $query);
            }
        
        return null;
    }

    private function validateLineByType($command, $opc, $numtest = 0, $numOper = 0 , $n = 0, $x1 = 0, $y1 = 0, $z1 = 0, $x2 = 0, $y2 = 0, $z2 = 0) {

        $textrequest = new SaveCubeRequest();

        $rules = $textrequest->rules($opc, $n, $x1, $y1, $z1, $x2, $y2, $z2);
        $messages = $textrequest->messages($opc, $numtest, $numOper);
        $validator = Validator::make($command, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('cube-index')->with('errors', $errors);
        }

        return null;
    }

    private function manualError($message) {
        $command = array();
        $messages = ['required' => $message,];
        $validator = Validator::make($command, ['required',], $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('cube-index')->with('errors', $errors);
        }
        return null;
    }

}
