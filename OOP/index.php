<?php
    function sum($a, $b){
        return $a + $b;
    }
    $sumReflector = new ReflectionFunction('sum');
    echo $sumReflector->getFileName().'<br>';
    echo $sumReflector->getStartLine().'<br>';
    echo $sumReflector->getEndLine().'<br>';

?>