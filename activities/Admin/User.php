<?php

namespace Admin;

use database\DataBase;

class User extends Admin
{

    public function index()
    {

        $db = new DataBase();
        $users = $db->select('SELECT * FROM `users` ORDER BY `id`DESC ')->fetchAll();
        require_once(BASE_PATH . '/template/admin/users/index.php');

    }

    public function edit($id)
    {
        $db = new DataBase();
        $user = $db->select('SELECT * FROM `users`WHERE id = ? ;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/users/edit.php');
    }

    public function update($request, $id)
    {
        $db = new DataBase();
        $db->update('users', $id, array_keys($request), $request);
        $this->redirect('admin/user');
    }

    public function delete($id)
    {
        $db = new DataBase();
        $db->delete('users', $id);
        $this->redirect('admin/user');
    }
    public function admin($id)
    {
        $db = new DataBase();
        $user=$db->select('SELECT * FROM users WHERE id = ?', [$id])->fetch();
        if(empty($user))
        {
            $this->redirect('admin/user');

        }
        if($user['permission'] ==='admin')
        {
            $db->update('users', $id, ['permission'], ['user']);
        }
        else
        {
            $db->update('users', $id, ['permission'], ['admin']);
        }
        $this->redirect('admin/user');
    }


}