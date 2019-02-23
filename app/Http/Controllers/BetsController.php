<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BetsController extends Controller
{
    protected $bets = [];
    protected $size;
    protected $amount;
    protected $filename = 'resultados_megasena.csv';
    protected $delimiter = ';';

    protected $bestNumbers = [10, 5, 53, 4, 23, 33, 54, 24, 51, 17, 
                    42, 27, 37, 52, 43, 13, 28, 30, 56, 34, 6, 32, 
                    44, 2, 16, 29, 41, 50, 36, 18, 35, 8];

    public function generate(Request $request) {
        // dump($request->all());
        $this->size = $request->size;
        $this->amount = $request->amount;

        for($i = 0; $i < $this->amount; $i++) {
            $bet = $this->generateValidBet();
            // echo '<p style="font-weight: bold; color:green">'.($i+1).'</p>';
            // echo '<p style="font-weight: bold; color:green">'
            //                     .$bet[0].' '
            //                     .$bet[1].' '
            //                     .$bet[2].' '
            //                     .$bet[3].' '
            //                     .$bet[4].' '
            //                     .$bet[5].' ';
            array_push($this->bets, $bet);
        }

        // dump($this->bets);

        return redirect()->back()->with(['bets' => $this->bets]);
    }

    public function generateValidBet() {
        $size = $this->size;
        $keep = false; 
        $bet = [];

        do{
            $bet = [];
            $index = 1;
            while($index < ($size+1)){
                $value = rand(1, 60);
                if(!in_array($value, $bet)){
                    array_push($bet, $value);
                    $index++;
                }
            }
            sort($bet);

            $keep = !$this->validateBet($bet);
        }while($keep == true);

        return $bet;
    }

    public function validateBet($bet) {
        // dump($bet);

        $filename = $this->filename;
        $delimiter = $this->delimiter;
        $size = $this->size;

        $bestNumbers = $this->bestNumbers;
        
        $equals = 0;
        for($i = 0; $i < 30; $i++){
            for($j = 0; $j < $size; $j++){
                if($bet[$j] == $bestNumbers[$i]){
                    $equals++;
                }
            }
        }
        if($equals >= 2){
            // echo '<p style="font-weight: bold; color:green">'.$equals.' estão entre os 30 números mais sorteados</p>';
        }else{
            // echo '<p style="font-weight: bold; color:red">'.$equals.' estão entre os 30 números mais sorteados</p>';
            // $keep = true;
            return false;
        }

        $evens = 0;
        $odds = 0;
        for($i = 0; $i < $size; $i++){
            if($bet[$i] % 2 == 0){
                $evens++;
            }else{
                $odds++;
            }
        }
        if($size % 2 == 0){
            if($evens > ($size/2)){
                // echo '<p style="font-weight: bold; color:red">'.$evens.' dezenas pares</p>';
                // $keep = true;
                return false;
            }else if($odds > ($size/2)){
                // echo '<p style="font-weight: bold; color:red">'.$odds.' dezenas impares</p>';
                // $keep = true;
                return false;
            }else{
                // echo '<p style="font-weight: bold; color:green">'.$evens.' dezenas pares</p>';
                // echo '<p style="font-weight: bold; color:green">'.$odds.' dezenas impares</p>';
            }
        }else{
            if($evens > (($size/2)+1)){
                // echo '<p style="font-weight: bold; color:red">'.$evens.' dezenas pares</p>';
                // $keep = true;
                return false;
            }else if($odds > (($size/2)+1)){
                // echo '<p style="font-weight: bold; color:red">'.$odds.' dezenas impares</p>';
                // $keep = true;
                return false;
            }else{
                // echo '<p style="font-weight: bold; color:green">'.$evens.' dezenas pares</p>';
                // echo '<p style="font-weight: bold; color:green">'.$odds.' dezenas impares</p>';
            }
        }

        $sum = 0;
        for($i = 0; $i < $size; $i++){
            $sum += $bet[$i];
        }
        if($sum >= 151 && $sum <= 216){
            // echo '<p style="font-weight: bold; color:green">Soma das dezenas: '.$sum.'</p>';
        }else{
            // echo '<p style="font-weight: bold; color:red">Soma das dezenas: '.$sum.'</p>';
            // $keep = true;
            return false;
        }

        $history = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                array_shift($row);
                array_shift($row);
                array_pop($row);
                array_push($history, $row);
            }
            fclose($handle);
        }

        if ($size == 6) {
            $equals = 0;
            // $keep = true;
            for($historyIndex = 0; $historyIndex < count($history); $historyIndex++){
                for($betIndex = 0; $betIndex < count($bet); $betIndex++){
                    if($this->equal($history[$historyIndex], $bet)){
                        // echo '<p style="font-weight: bold; color:red">'.($historyIndex+1).
                        // ' Jogo já foi sorteado: '
                        //         .$history[$historyIndex][0].' '
                        //         .$history[$historyIndex][1].' '
                        //         .$history[$historyIndex][2].' '
                        //         .$history[$historyIndex][3].' '
                        //         .$history[$historyIndex][4].' '
                        //         .$history[$historyIndex][5].' ';
                        // $keep = true;
                        return false;
                    }
                }
            }
        } else {
            $in = $bet;
            $minLength = 6;
            $max = 6;
            $count = count($in);
            $members = pow(2, $count);
            $possible = array();
            for($i = 0; $i < $members; $i ++) {
                $b = sprintf("%0" . $count . "b", $i);
                $out = array();
                for($j = 0; $j < $count; $j ++) {
                    $b{$j} == '1' and $out[] = $in[$j];
                }
    
                count($out) >= $minLength && count($out) <= $max and $possible[] = $out;
            }
            sort($possible);
    
            $equals = 0;
            // $keep = true;
            for($historyIndex = 0; $historyIndex < ($game-2); $historyIndex++){
                for($possibleIndex = 0; $possibleIndex < count($possible); $possibleIndex++){
                    if(equal($history[$historyIndex], $possible[$possibleIndex])){
                        echo '<p style="font-weight: bold; color:red">Jogo já foi sorteado: '
                                .$history[$historyIndex][0].' '
                                .$history[$historyIndex][1].' '
                                .$history[$historyIndex][2].' '
                                .$history[$historyIndex][3].' '
                                .$history[$historyIndex][4].' '
                                .$history[$historyIndex][5].' ';
                        // $keep = true;
                        return false;
                    }
                }
            }
        }

        // echo '<p style="font-weight: bold; color:green">Nenhum jogo já foi sorteado';
        
        return true;
    }

    function equal($bet1, $bet2){
        sort($bet1);
        for($i = 0; $i < count($bet1); $i++)
            $bet1[$i] = intval($bet1[$i]);
        sort($bet2);
        for($i = 0; $i < count($bet1); $i++)
            $bet2[$i] = intval($bet2[$i]);
    
        if($bet1 == $bet2)
            return true;
        return false;
    }

    public function download(Request $request) {
        if ($request->format == 'json') {
            return response()->streamDownload(function () use ($request) {
                echo $request->bets;
            }, 'bets.json');
        } elseif ($request->format == 'csv') {
            return response()->streamDownload(function () use ($request) {
                echo $this->str_putcsv(json_decode($request->bets));
            }, 'bets.csv');

            // dump($this->str_putcsv(json_decode($request->bets)));
        }
    }

    public function str_putcsv($data, $delimiter = ';') {
        # Generate CSV data from array
        $fh = fopen('php://temp', 'rw'); # don't create a file, attempt
                                        # to use memory instead

        # write out the headers
        fputcsv($fh, $this->getArrayKeys($data[0]), $delimiter);

        # write out the data
        $count = 1;
        foreach ( $data as $row ) {
            $row = array_merge([$count++], $row);
            fputcsv($fh, $row, $delimiter);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        return $csv;
    }

    public function getArrayKeys($arr) {
        $response = ['Jogo'];
        $count = 1;
        foreach ($arr as $item) {
            array_push($response, $count++.' dezena');
        }
        return $response;
    }

    public function hits(Request $request) {
        $bets = json_decode(file_get_contents($request->bets->path()), true);
        $betSize = count($bets[0]);
        $result = explode(',', $request->result);
        $hits = [];

        foreach ($bets as $bet) {
            $count = 0;
            foreach ($bet as $n) {
                if (in_array($n, $result)) {
                    $count++;
                }
            }
            array_push($hits, $count);
        }

        return view('hits', ['bets' => $bets, 'hits' => $hits]);
    }

}
