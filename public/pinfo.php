<?php
$test = array( 123, 2,32 ,233,435, 545, 646, 3, 23, 56,63 );

function sortA( $val, $key, $arr ) {
    if ( $val < $arr[$key +1 ] ) {
        $arr[$key] = $arr[$key+1];
        $arr[$key+1] = $val;
    }
}
array_walk( $test, "sortA", $test );
print_r( $test );
