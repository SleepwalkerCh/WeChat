<?php
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) 
	{ 
	   $wechatObj->valid();
	}
else
	{
	    $wechatObj->responseMsg();
	}
class wechatCallbackapiTest
{    
	public function valid()    
	{       
		 $echoStr = $_GET["echostr"];       
		 if($this->checkSignature()){            
		 	echo $echoStr;        
		    exit;     
		    }
    }    
    private function checkSignature()    
    {     
       $signature = $_GET["signature"];      
       $timestamp = $_GET["timestamp"];       
       $nonce = $_GET["nonce"];      
       $token = "weixin";        
       $tmpArr = array($token, $timestamp, $nonce);        
       sort($tmpArr);        
       $tmpStr = implode( $tmpArr );        
       $tmpStr = sha1( $tmpStr );        
       if( $tmpStr == $signature )
       	{            
       		return true;        
       	}
       	else
       		{            
       			return false;        
       		}    
       	}    
       	public function responseMsg()    {       
       		 $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
             require('./IndexModel.php');
       		 if (!empty($postStr))
       		 	{            
       		 		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);            
                 //$fromUsername = $postObj->FromUserName;            
                 ///$toUsername = $postObj->ToUserName;            
       		 		$keyword = trim($postObj->Content);            
                 //$time = time();           
                 /*$textTpl = "<xml>                        
       		 		<ToUserName><![CDATA[%s]]></ToUserName>                        
       		 		<FromUserName><![CDATA[%s]]></FromUserName>                        
       		 		<CreateTime>%s</CreateTime>                        
       		 		<MsgType><![CDATA[%s]]></MsgType>                        
       		 		<Content><![CDATA[%s]]></Content>                        
       		 		<FuncFlag>0</FuncFlag>                        
       		 		</xml>"; */           
                    $IndexModel=new IndexModel();
       		 		if($keyword == "?" || $keyword == "？")            
       		 			{  
                         	$contentStr = date("Y-m-d H:i:s",time());
                         	$IndexModel->responseText($postObj,$contentStr);
       		 			}   
       		 		if ($keyword == "石头"|| $keyword == "布" || $keyword == "剪刀")
       		 		{
       		 			
       		 			$arr=array("石头","剪刀","布");
       		 			$arrNum=rand(0,2);
						$contentStr = $arr[$arrNum]."  ";
						$contentTemp="";
						if($keyword == "石头")
    						if ($arrNum==0) {$contentTemp="平局";}
     							 elseif ($arrNum==1){$contentTemp="你赢了";}
              						else {$contentTemp="你输了";}
						if($keyword == "剪刀")
    						if ($arrNum==1) {$contentTemp="平局";}
      							elseif ($arrNum==2){$contentTemp="你赢了";}
              						else {$contentTemp="你输了";}
						if($keyword == "布")
    						if ($arrNum==2) {$contentTemp="平局";}
      							elseif ($arrNum==0){$contentTemp="你赢了";}
              						else {$contentTemp="你输了";}  
       		 		$contentStr=$contentStr.$contentTemp;
       		 		$IndexModel->responseText($postObj,$contentStr);
                        //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);               
                        //echo $resultStr;        
					}
       		 		}
       		 		else
       		 			{            
       		 				echo "";            
       		 				exit;        
       		 			}    
       		 	}
       		 }
  ?>
