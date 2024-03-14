<?php

    class Employee{
        private $name;
        private $civil_status;
        private $position;
        private $employment_status;
        private $hours_worked;
        private $regular_rate = [
            'staff' => ['contractual' => 300, 'probationary' => 350, 'regular' => 400],
            'admin' => ['contractual' => 350, 'probationary' => 400, 'regular' => 500]
        ];
        private $overtime_rate = [
            'staff' => ['contractual' => 10, 'probationary' => 25, 'regular' => 30],
            'admin' => ['contractual' => 15, 'probationary' => 30, 'regular' => 40]
        ];
        private $healthcare = ['single' => 200, 'married' => 75];
        private $tax = ['single' => 0.05, 'married' => 0.03];

        public function __construct($name, $civil_status, $position, $employment_status, $hours_worked){
            $this->name = $name;
            $this->civil_status = $civil_status;
            $this->position = $position;
            $this->employment_status = $employment_status;
            $this->hours_worked = $hours_worked;
        }

        public function computeRegularPay(){
            if($this->hours_worked > 40){
                return ($this->regular_rate[$this->position][$this->employment_status] / 8) * 40;
            }else{
                return ($this->regular_rate[$this->position][$this->employment_status] / 8) * $this->hours_worked;
            }
        }

        public function computeOvertimePay(){
            if($this->hours_worked > 40){
                $overtime = $this->hours_worked - 40;
            }else{
                $overtime = 0;
            }

            return $this->overtime_rate[$this->position][$this->employment_status] * $overtime;
        }

        public function computeGrossIncome(){
            return $this->computeRegularPay() + $this->computeOvertimePay();
        }

        public function computeTax(){
            if($this->computeGrossIncome() > 1000 && $this->civil_status == 'single' || $this->computeGrossIncome() > 1500 && $this->civil_status == 'married'){
                return $this->computeGrossIncome() * $this->tax[$this->civil_status];
            }else{
                return 0;
            }
        }

        // public function computeHealthCare(){
        //     return $this->healthcare[$this->civil_status];
        // }

        public function computeNetIncome(){
            // return $this->computeGrossIncome() - ($this->computeTax() + $this->computeHealthCare());
            return $this->computeGrossIncome() - ($this->computeTax() + $this->healthcare[$this->civil_status]);
        }
    }

?>