<?php
/**
 * Created by PhpStorm.
 * User: jokeikusunoki
 * Date: 16/11/8
 * Time: 下午8:12
 */

require_once('Sign.php');

$timeStamp  = time();
$hsqSign    = new DWDData_Sign();
$hsqSign->SetAppid( 'M_101' );
$hsqSign->SetTimeStamp( $timeStamp );
$hsqSign->SetSign( $hsqSign->MakeSign('test'));
echo json_encode( $hsqSign->GetValues() );