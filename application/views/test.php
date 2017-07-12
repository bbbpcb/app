<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<form name="form1" method="post" action="<?=base_url()?>index.php?c=api">
<table width="721" height="360" border="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td height="31" valign="top" bgcolor="#FFFFFF">URL：</td>
    <td height="31" valign="top" bgcolor="#FFFFFF"><label>
      <input name="url" type="text" size="80" />
    </label></td>
  </tr>
  <tr>
    <td width="112" height="280" valign="top" bgcolor="#FFFFFF"><label></label>
      DATA
      ：</td>
    <td width="602" valign="top" bgcolor="#FFFFFF"><label>
      <textarea name="data" cols="80" rows="20"></textarea>
    </label></td>
  </tr>
  <tr>
    <td height="37" valign="top" bgcolor="#FFFFFF"><label>
      <input type="submit" value="提交" />
    </label></td>
    <td width="602" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>
<table width="721" height="364" border="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td height="152" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="152" valign="top" bgcolor="#FFFFFF"><label></label></td>
  </tr>
  <tr>
    <td width="112" height="280" rowspan="8" valign="top" bgcolor="#FFFFFF"><label></label>
    集体攻关</td>
    <td width="602" height="32" valign="top" bgcolor="#FFFFFF"><label><?=base_url()?>index.php?d=api&c=conquer&m=create(创建)</label></td>
  </tr>
  <tr>
    <td height="58" valign="top" bgcolor="#FFFFFF">
	  <p>
	    <?php
		    	/**集体攻关****/
    	$arr = array('name'=>'conquer',
    		'data'=>array(
    			'title'=>'admin',
    			'uid'=>'1',
    			'typeid'=>'1',
    			'content'=>'13800138000',
    			'icon'=>'1',
    			'total' =>20,
    			'token' =>'abc123'
    			)
    		);
    	/**集体攻关****/

    	echo json_encode($arr);
	?>
    </p>
    <p>&nbsp;  </p></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><?=base_url()?>index.php?d=api&c=conquer&m=summary(专家总结)</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
		    <?php
		    	/**集体攻关****/
    	$arr = array('name'=>'summary',
    		'data'=>array(
    			'id'=>1,
    			'uid'=>'1',
    			'content'=>'1',
    			
    			'token' =>'abc123'
    			)
    		);
    	/**集体攻关****/

    	echo json_encode($arr);
	?>	</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF"><?=base_url()?>index.php?d=api&c=conquer&m=reply(员工解答)</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">
			    <?php
		    	/**集体攻关****/
    	$arr = array('name'=>'reply',
    		'data'=>array(
    			'cid'=>5,
    			'mid'=>'1',
    			'content'=>'我能完成这个任务',  			
    			'token' =>'abc123'
    			)
    		);
    	/**集体攻关****/

    	echo json_encode($arr);
	?>
	</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="37" valign="top" bgcolor="#FFFFFF"><label></label></td>
    <td width="602" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>

</body>
</html>
