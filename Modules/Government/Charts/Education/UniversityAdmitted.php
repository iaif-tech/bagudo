<?php

namespace Modules\Government\Charts\Education;

use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;

class University extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lga = [
            'Binji',
            'Bodinga',
            'Dange Shuni',
            'Gada',
            'Goronyo',
            'Gudu',
            'Gwadabawa',
            'Illela',
            'Isa',
            'Kebbe',
            'Kware',
            'Rabah',
            'Sabon Birni',
            'Shagari',
            'Silame',
            'Sokoto North',
            'Sokoto South',
            'Tambuwal',
            'Tangaza',
            'Tureta',
            'Wamakko',
            'Wurno',
            'Yabo'
        ];
    }
    public function admitted()
    {
        $this->labels($this->lga);
        $admitted = $this->dataset('Universities Report 2019', 'Bar',[
            
            '10',
            '3',
            '4',
            '4',
            '4',
            '3',
            '9',
            '7',
            '20',
            '5',
            '15',
            '7',
            '8',
            '7',
            '0',
            '6',
            '6',
            '2',
            '2',
            '4',
            '6',
            '6',
            '8'
        ])->color('#6da252');
        return $admitted;
    }
    public function graduated()
    {
        $this->labels($this->lga);
        $graduated = $this->dataset('Universities Report 2019', 'Bar',[
            
            '10',
            '3',
            '4',
            '4',
            '4',
            '3',
            '9',
            '7',
            '20',
            '5',
            '15',
            '7',
            '8',
            '7',
            '0',
            '6',
            '6',
            '2',
            '2',
            '4',
            '6',
            '6',
            '8'
        ])->color('#6da252');
        return $graduated;
    }
}
