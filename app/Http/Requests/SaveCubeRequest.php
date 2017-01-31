<?php

namespace App\Http\Requests;

class SaveCubeRequest 
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
        public function rules($cases,$n=0,$x1=0,$y1=0,$z1=0,$x2=0,$y2=0,$z2=0)
    {        
        switch ($cases) {
            case 1:  
                $this->arrayrules=array();
                array_push($this->arrayrules,'required|numeric|between:1,50'); 
                break;
            case 2:
                $this->arrayrules=array();
                array_push($this->arrayrules,'required|numeric|between:1,100');
                array_push($this->arrayrules,'required|numeric|between:1,1000');
                break;
            case 5:
                $this->arrayrules=array();
                array_push($this->arrayrules,'required|in:UPDATE');
                array_push($this->arrayrules,'required|numeric|between:1,'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:1,'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:1,'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:-1000000000,1000000000');

                break;
            case 7:
                $this->arrayrules=array();
                array_push($this->arrayrules,'required|in:QUERY');
                array_push($this->arrayrules,'required|numeric|between:1,'.$x2.'|max:'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:1,'.$y2.'|max:'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:1,'.$z2.'|max:'.$n.'');
                array_push($this->arrayrules,'required|numeric|between:'.$x1.','.$n);
                array_push($this->arrayrules,'required|numeric|between:'.$y1.','.$n);
                array_push($this->arrayrules,'required|numeric|between:'.$z1.','.$n);
                break;
        }

        return $this->arrayrules;
    }


        public function messages($cases,$line=null,$operation=null)
    {
        switch ($cases) {
            case 1:
                $this->arraymessages=array();
                $this->arraymessages['0.required']='Error. You must enter the number of test cases (T)';
                $this->arraymessages['0.numeric']='Error. The variable T must be a number';
                $this->arraymessages['0.between']='Error. The variable T must be between 1 and 50';
                break;
            case 2:
                $this->arraymessages=array();
                $this->arraymessages['0.required']='Error. testcases #'.$line.', You must enter the matriz size (N).';
                $this->arraymessages['0.numeric']='Error. testcases #'.$line.', The variable N must be a number.';
                $this->arraymessages['0.between']='Error. testcases #'.$line.', The variable N must be between 1 and 100';

                $this->arraymessages['1.required']='Error. testcases #'.$line.', You must defines the number of operations (M).';
                $this->arraymessages['1.numeric']='Error. testcases #'.$line.', The variable M must be a number.';
                $this->arraymessages['1.between']='Error. testcases #'.$line.', The variable M must be between 1 and 1000';
                break;
            case 5:
                $this->arraymessages=array();
                $this->arraymessages['0.required']='Error. Operation required #'.$line.' - operation '.$operation;
                $this->arraymessages['0.in']='Error. testcases #'.$line.' - operation '.$operation.'. The operation should start with UPDATE.';

                $this->arraymessages['1.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['1.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable x must be a number.';
                $this->arraymessages['1.between']='Error. testcases #'.$line.' - operation '.$operation.', he variable x must be between 1 and N';

                $this->arraymessages['2.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['2.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable y must be a number.';
                $this->arraymessages['2.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable y must be between 1 and N';

                $this->arraymessages['3.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['3.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable z must be a number.';
                $this->arraymessages['3.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable z must be between 1 and N';

                $this->arraymessages['4.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['4.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable W must be a number.';
                $this->arraymessages['4.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable W must be between -1000000000 and 1000000000.';

                break;
            case 7:
                $this->arraymessages=array();
                $this->arraymessages['0.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['0.in']='Error. testcases #'.$line.' - operation '.$operation.', The operation should start with QUERY.';

                $this->arraymessages['1.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['1.numeric']='Er1ror. testcases #'.$line.' - operation '.$operation.', The variable x1 must be a number.';
                $this->arraymessages['1.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable x1 must be between 1 and x2.';
                $this->arraymessages['1.max']='Error. testcases #'.$line.' - operation '.$operation.', x1 can not be greater than N.';

                $this->arraymessages['2.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['2.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable y1 must be a number.';
                $this->arraymessages['2.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable y1 must be between 1 and y2.';
                $this->arraymessages['2.max']='Error. testcases #'.$line.' - operation '.$operation.', y1 can not be greater than N.';

                $this->arraymessages['3.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['3.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable z1 must be a number.';
                $this->arraymessages['3.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable z1 must be between 1 and z2..';
                $this->arraymessages['3.max']='Error. testcases #'.$line.' - operation '.$operation.', z1 can not be greater than N.';

                $this->arraymessages['4.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['4.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable x2 must be a number.';
                $this->arraymessages['4.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable x2 must be between x1 and N';

                $this->arraymessages['5.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['5.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable y2 must be a number.';
                $this->arraymessages['5.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable y2 must be between y1 and N';

                $this->arraymessages['6.required']='Error. testcases #'.$line.' - operation '.$operation;
                $this->arraymessages['6.numeric']='Error. testcases #'.$line.' - operation '.$operation.', The variable z2 must be a number.';
                $this->arraymessages['6.between']='Error. testcases #'.$line.' - operation '.$operation.', The variable z2 must be between z1 and N';

                break;
        }

        return $this->arraymessages;
    }



}
