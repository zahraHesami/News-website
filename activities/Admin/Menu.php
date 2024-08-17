<?php
namespace Admin;
use database\DataBase;

class  Menu extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $menus = $db->select('SELECT menus.* ,menus1.name as parent_name FROM `menus` LEFT JOIN menus as menus1 ON menus.parent_id =menus1.id ORDER BY `id`DESC ')->fetchAll();
        require_once(BASE_PATH . '/template/admin/menus/index.php');

    }
    public function create()
    {
        $db = new DataBase();
        $menus = $db->select('SELECT * FROM `menus` WHERE  parent_id IS NULL ORDER BY `id`DESC ')->fetchAll();
        require_once(BASE_PATH . '/template/admin/menus/create.php');
    }

    public function store($request)
    {
        $db = new DataBase();
        $db->insert('menus',array_keys(array_filter($request)),array_filter($request));
        $this->redirect('admin/menu');

    }
    public function edit($id)
    {
        $db = new DataBase();
        $menu = $db->select('SELECT * FROM `menus`WHERE id = ? ;',[$id])->fetch();
        $menus = $db->select('SELECT * FROM `menus` WHERE  parent_id IS NULL ORDER BY `id`DESC ')->fetchAll();
        require_once(BASE_PATH . '/template/admin/menus/edit.php');
    }
    public function update($request,$id)
    {
        $db = new DataBase();
        $db->update('menus',$id,array_keys($request),$request);
        $this->redirect('admin/menu');
    }
    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('menus',$id);
        $this->redirect('admin/menu');
    }



}