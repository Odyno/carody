<?php

function mynamespace_subtractTwoNumbers( $args ) {
    $number1 = (int) $args[0];
    $number2 = (int) $args[1];
    return $number1 - $number2;
}

function mynamespace_new_xmlrpc_methods( $methods ) {
    $methods['carody.subtractTwoNumbers'] = 'mynamespace_subtractTwoNumbers';
    return $methods;   
}
add_filter( 'xmlrpc_methods', 'mynamespace_new_xmlrpc_methods');

?>
