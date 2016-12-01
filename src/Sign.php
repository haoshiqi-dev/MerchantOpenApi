<?php
/**
 * Created by PhpStorm.
 * User: szl
 * Date: 16-11-7
 * Time: 上午11:35
 */
class DWDData_Sign{

    protected $values = array();

    /**
     * 获取设置的值
     */
    public function GetValues()
    {
        return $this->values;
    }
    /**
     * 设置分配的公众账号ID
     * @param string $value
     **/
    public function SetAppid($value)
    {
        $this->values['appId'] = $value;
    }
    /**
     * 获取分配的公众账号ID的值
     * @return 值
     **/
    public function GetAppid()
    {
        return $this->values['appId'];
    }

    /**
     * 设置调用Api时间戳
     * @param string $value
     **/
    public function SetTimeStamp($value)
    {
        $this->values['timeStamp'] = $value;
    }
    /**
     * 获取调用Api时间戳的值
     * @return 值
     **/
    public function GetTimeStamp()
    {
        return $this->values['timeStamp'];
    }


    /**
     * 设置签名方式
     * @param string $value
     **/
    public function SetSign($value)
    {
        $this->values['sign'] = $value;
    }
    /**
     * 获取签名方式
     * @return 值
     **/
    public function GetSign()
    {
        return $this->values['sign'];
    }

    public function MakeSign( $privateKey )
    {

        ksort( $this->values );
        $string = self::ToUrlParams();

        $string = $string . "&privateKey=".$privateKey;
        $string = md5($string);
        $result = strtoupper($string);
        return $result;
    }

    public function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
}
