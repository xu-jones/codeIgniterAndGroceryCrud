<?php
# 加载七牛SDK
require_once( app_path('qiniu/rs.php') ); 
Qiniu_SetKeys('O5OQnIPVV8y1cBmLn8yeaH58QjJ2kHLxB-mbcG5R', 'dLoulit_AazujFZRxPLSpOTBW_ht5IYRCDVsNbn-');

class QiniuApi  
{ 
    
    public static $bucket = 'minisite-nfl'; //空间
    
    # 查看文件属性
    public static function FileDetail($key)
    {   
        try 
        {
            if(empty($key))
            {
                throw new Exception('缺少参数',-1);
            }
            
            $client = new Qiniu_MacHttpClient(null);
     
            list($rs, $err) = Qiniu_RS_Stat($client, self::$bucket, $key);

            if ($err !== null) 
            { 
                throw new Exception($err['Err'], $err['Code']); 
            } 
             
            $data =  array(
                'code'  =>0,
                'data'  =>$rs
            ); 
        } 
        catch (Exception $e) 
        {
            $data = array(
                'code'  =>$e->getCode(),
                'msg'   =>$e->getMessage(),
            );
        }
        
        return $data;
        
    }
    
    
     
    /**
     *  文件上传
     * @param array $file 
     * @param string $tmpName
     * @return array 
     */
    public static function Upload($filename, $tmpName)
    {
        try
        {
            require_once( app_path('qiniu/io.php') );
            if( empty($filename) || empty($tmpName) )
            {
                throw new Exception('缺少参数',-1);
            }
    
            $putPolicy = new Qiniu_RS_PutPolicy(self::$bucket);
            $upToken = $putPolicy->Token(null);
            
            $putExtra = new Qiniu_PutExtra();
            $putExtra->Crc32 = 1;
             
            list($ret, $err) = Qiniu_PutFile($upToken, $filename, $tmpName , $putExtra);
            
           
            if ( $err !== null ) 
            { 
                throw new Exception($err->Err, $err->Code); 
            } 
            
            $data =  array(
                'code'  =>0,
                'data'  =>$ret
            ); 
             
        }
        catch (Exception $e)
        {
            $data = array(
                'code'  =>$e->getCode(),
                'msg'   =>$e->getMessage(),
            );
        } 
        return $data;
    }
    
    /**
     * 删除单个文件
     */
    public static function DelFile($key)
    {  
        try
        {
            if( empty($key) )
            {
                throw new Exception('缺少参数',-1);
            }
            $client = new Qiniu_MacHttpClient(null);

            $err = Qiniu_RS_Delete($client, self::$bucket, $key);
           
            if ($err !== null) 
            {
                throw new Exception($err->Err, $err->Code); 
            } 
            
            $data =  array(
                'code'  =>0, 
            ); 
        }
        catch (Exception $e)
        {
            $data = array(
                'code'  =>$e->getCode(),
                'msg'   =>$e->getMessage(),
            );
        } 
        return $data;
    }
    
}
