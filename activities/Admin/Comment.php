<?php
namespace Admin;

use database\DataBase;

class Comment extends Admin
{

    public function index()
    {

        $db = new DataBase();

        $unseenComment = $db ->select('SELECT * FROM `comments` WHERE `status` = ?',['unseen']);
        foreach ($unseenComment as $comment)
        {
            $db->update('comments', $comment['id'], ['status'], ['seen']);
        }
        $comments = $db->select('SELECT comments.* ,users.username as user_name ,posts.title as post_title FROM ( comments LEFT JOIN  users ON comments.user_id = users.id) LEFT JOIN 
    posts ON comments.post_id= posts.id  ORDER BY `id`DESC ')->fetchAll();
        require_once(BASE_PATH . '/template/admin/comments/index.php');

    }

    public function show($id)
    {
        $db = new DataBase();
        $user = $db->select('SELECT * FROM `users`WHERE id = ? ;', [$id])->fetch();
        require_once(BASE_PATH . '/template/admin/users/edit.php');
    }
    public function  changeStatus($id)
    {
        $db = new DataBase();
        $comment = $db->select('SELECT * FROM `comments`WHERE id = ? ;', [$id])->fetch();
        if(empty($comment))
        {
            $this->redirect('admin/comment');

        }
        if($comment['status'] == 'seen')
        {
            $db->update('comments', $id, ['status'], ['approved']);
        }
        else
        {
            $db->update('comments', $id, ['status'], ['seen']);
        }
        $this->redirect('admin/comment');
    }

}