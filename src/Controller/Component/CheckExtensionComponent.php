<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class CheckExtensionComponent extends Component
{
  function chk_ext( $chk_name, $allow_exts=array( "png", "pdf", "jpg" ) ) {
    //使用出来ない拡張子のチェック
    $ext_err = false;
    $exts = preg_split( "/[.]/", $chk_name );// ファイル名を.で分割する。
    if( count( $exts ) < 2 ) return $ext_err;
    $ext = $exts[ count( $exts ) - 1 ];//.で分割した最後のブロックの文字列を取得する
    foreach(  $allow_exts as $val ) {
        if( !empty( $val ) ) {
            //$len = strlen( $val );
            //if( strncasecmp( strtoupper($val), strtoupper($ext), $len ) == 0 ) {
            if( strcasecmp( $val, $ext ) == 0 ) { //修正しました(2016/03/23/01:22)
                $ext_err = true;//エラーフラグ 偽に変更
                break;
            }
        }
    }
    $ret = $ext_err;
    return $ret;
  }

}
