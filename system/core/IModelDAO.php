<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-3
 * Time: 下午3:45
 */

interface IModelDAO{


    public function save($obj);

    public function update($obj);

    public function del($obj);


}