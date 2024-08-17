<?php

namespace Admin;

use database\DataBase;

class Post extends Admin
{

    public function index()
    {
        $db = new DataBase();
        $posts = $db->select('SELECT posts.*,users.username, categories.name as cat_name FROM ( posts LEFT JOIN categories ON posts.cat_id = categories.id) LEFT JOIN users ON posts.user_id = users.id;')->fetchAll();
        require_once(BASE_PATH . '/template/admin/posts/index.php');

    }

    public function create()
    {

        $db = new DataBase();
        $categories = $db->select('SELECT * FROM categories;')->fetchAll();
        require_once(BASE_PATH . '/template/admin/posts/create.php');
    }

    public function store($request)
    {
        date_default_timezone_set('Iran');
        $realTimeStamp = substr($request['published_at'], 0, 10);
        $request['published_at']=date('Y-m-d H:i:s', (int)$realTimeStamp);


        $db = new DataBase();
        if($request['cat_id'] !== null)
        {
            $request['image']=$this ->saveImage($request['image'],'post-image');
            if($request['image'])
            {
              $request =array_merge($request,['user_id'=>1]);
              $db->insert('posts',array_keys($request),$request );
              $this->redirect('admin/post');
            }
            else
            {
                $this->redirect('admin/post');
            }
        }
        else
        {
            $this->redirect('admin/post');
        }


    }

    public function edit($id)
    {
        $db = new DataBase();
        $post = $db->select('SELECT * FROM `posts`WHERE id = ? ;', [$id])->fetch();
        $categories = $db->select('SELECT * FROM categories;')->fetchAll();
        require_once(BASE_PATH . '/template/admin/posts/edit.php');
    }

    public function update($request, $id)

    {
        date_default_timezone_set('Iran');
        $realTimeStamp = substr($request['published_at'], 0, 10);
        $request['published_at']=date('Y-m-d H:i:s', (int)$realTimeStamp);

        $db = new DataBase();
        if($request['cat_id'] !== null)
        {
            if($request['image']['tmp_name'] !== null)
            {
                $post = $db->select('SELECT * FROM `posts`WHERE id = ? ;', [$id])->fetch();
                $this->removeImage($post['image']);
                $request['image']=$this ->saveImage($request['image'],'post-image');
            }
            else
            {
               unset($request['image']);
            }
            $request=array_merge($request,['user_id'=>$_SESSION['user']]);
            $db->update('posts', $id, array_keys($request), $request);
            $this->redirect('admin/post');
        }
        else
        {
            $this->redirect('admin/post');
        }

    }

    public function delete($id)
    {

         $db = new DataBase();
         $post=$db->select('SELECT * FROM posts WHERE id = ?', [$id])->fetch();
         $this->removeImage($post['image']);
         $db->delete('posts', $id);
         $this->redirect('admin/post');

    }
    public function  selected($id)
    {
            $db = new DataBase();
            $post=$db->select('SELECT * FROM posts WHERE id = ?', [$id])->fetch();
            if(empty($post))
            {
                $this->redirect('admin/post');

            }
            if($post['selected'] == 0)
            {
                $db->update('posts', $id, ['selected' ], [1]);
            }
            else
            {
                $db->update('posts', $id, ['selected' ], [0]);
            }
            $this->redirect('admin/post');
    }
    public function  breakingNews($id)
    {
        $db = new DataBase();
        $post=$db->select('SELECT * FROM posts WHERE id = ?', [$id])->fetch();
        if(empty($post))
        {
            $this->redirect('admin/post');

        }
        if($post['breaking_news'] == 0)
        {
            $db->update('posts', $id, ['breaking_news'], [1]);
        }
        else
        {
            $db->update('posts', $id, ['breaking_news'], [0]);
        }
        $this->redirect('admin/post');
    }

}