<?php

class Coder
{
    
    static function encode_pass($tex,$key,$type="encode"){
        $chrArr=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
                'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
                '0','1','2','3','4','5','6','7','8','9');
    
        if($type=="decode"){
            if(strlen($tex)<14)return false;
            $verity_str=substr($tex, 0,8);
            $tex=substr($tex, 8);
            if($verity_str!=substr(md5($tex),0,8)){
                //完整性验证失败
                return false;
            }
        }
    
        $key_b=$type=="decode"?substr($tex,0,6):$chrArr[rand()%62].$chrArr[rand()%62].$chrArr[rand()%62].$chrArr[rand()%62].$chrArr[rand()%62].$chrArr[rand()%62];
        $rand_key=$key_b.$key;
        $rand_key=md5($rand_key);
        $tex=$type=="decode"?base64_decode(substr($tex, 6)):$tex;
        $texlen=strlen($tex);
        $reslutstr="";
        for($i=0;$i<$texlen;$i++){
            $reslutstr.=$tex{$i}^$rand_key{$i%32};
        }
        if($type!="decode"){
            $reslutstr=trim($key_b.base64_encode($reslutstr),"==");
            $reslutstr=substr(md5($reslutstr), 0,8).$reslutstr;
        }
        return $reslutstr;
    }
    
    // 简单加密函数（与php_decrypt函数对应）
    static function php_encrypt ($str)
    {
        $encrypt_key = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
        
        if (strlen($str) == 0)
            return false;
        $enstr = '';
        for ($i = 0; $i < strlen($str); $i ++) {
            for ($j = 0; $j < strlen($encrypt_key); $j ++) {
                if ($str[$i] == $encrypt_key[$j]) {
                    $enstr .= $decrypt_key[$j];
                    break;
                }
            }
        }
        
        return $enstr;
    }
    
    // 简单解密函数（与php_encrypt函数对应）
    static function php_decrypt ($str)
    {
        $encrypt_key = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
        
        if (strlen($str) == 0)
            return false;
        $enstr = '';
        for ($i = 0; $i < strlen($str); $i ++) {
            for ($j = 0; $j < strlen($decrypt_key); $j ++) {
                if ($str[$i] == $decrypt_key[$j]) {
                    $enstr .= $encrypt_key[$j];
                    break;
                }
            }
        }
        
        return $enstr;
    }
    
    static function php_decrypt2 ($str)
    {
        $encrypt_key = 'abcdefghijklmnopqrstuvwxyz6234517890';
        $decrypt_key = 'ngzqtcobmuhelkpdawxfyivrsj2468021359';
    
        if (strlen($str) == 0)
            return false;
        $enstr = '';
        for ($i = 0; $i < strlen($str); $i ++) {
            for ($j = 0; $j < strlen($decrypt_key); $j ++) {
                if ($str[$i] == $decrypt_key[$j]) {
                    $enstr .= $encrypt_key[$j];
                    break;
                }
            }
        }
    
        return $enstr;
    }
}

?>