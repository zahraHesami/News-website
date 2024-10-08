<?php

namespace App;


use database\DataBase;

class Home
{
    public function index()
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL ')->fetchAll();
        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();

        $breakingNews = $db->select('SELECT * FROM posts WHERE posts.breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();

        $lastPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY  created_at DESC LIMIT 0,6')->fetchAll();

        $bodyBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
        $sideBarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
        $popularPost = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY  view DESC LIMIT 0,3')->fetchAll();

        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY comments_count  DESC LIMIT 0,3')->fetchAll();
        require_once(BASE_PATH . '/template/app/index.php');
    }

    public function show($id)
    {
        $db = new DataBase();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL ')->fetchAll();
        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();


        $sideBarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY comments_count  DESC LIMIT 0,3')->fetchAll();


        $post= $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.id= ? ;',[$id])->fetch();

        $comments= $db->select('SELECT  comments.*, (SELECT username FROM users WHERE users.id = comments.user_id) AS username FROM comments WHERE post_id =? AND status ="approved"',[$id])->fetchAll();
        require_once(BASE_PATH . '/template/app/show.php');

    }

    public function category($id)
    {

        $db = new DataBase();
        $category = $db->select('SELECT * FROM categories WHERE id =? ',[$id])->fetch();
        $setting = $db->select('SELECT * FROM websetting')->fetch();
        $menus = $db->select('SELECT * FROM menus WHERE parent_id IS NULL ')->fetchAll();
        $topSelectedPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE posts.selected = 1 ORDER BY created_at DESC LIMIT 0,3')->fetchAll();
          
          $popularPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
          (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
          (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY  view DESC LIMIT 0,3')->fetchAll();

        $sideBarBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
        $breakingNews = $db->select('SELECT * FROM posts WHERE posts.breaking_news = 1 ORDER BY created_at DESC LIMIT 0,1')->fetch();
        $bodyBanner = $db->select('SELECT * FROM banners LIMIT 0,1')->fetch();
        $mostCommentPosts = $db->select('SELECT  posts.*, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
        (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
        (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts  ORDER BY comments_count  DESC LIMIT 0,3')->fetchAll();

        $categoryPosts = $db->select('SELECT posts.*,(SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count, (SELECT username FROM users WHERE users.id = posts.user_id) AS username,
         (SELECT name FROM categories WHERE categories.id = posts.cat_id) AS category FROM posts WHERE cat_id = ? ORDER BY created_at DESC LIMIT 0,6', [$id])->fetchAll();
         
        require_once(BASE_PATH . '/template/app/category.php');

    }

    public function commentStore($request)
    {
             if($_SESSION['user'] && isset($_SESSION['user']))
             {
                $db = new DataBase();
                $db->insert('comments',['user_id','post_id','comment'],[$_SESSION['user'],$request['post_id'],$request['comment']]);
                $this->redirect('home');
             }
             else
             {
                $this->redirectBack();
             }
             
    }

    public function redirectBack()
    {
        header('Location:/' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    protected function redirect($url)
    {
         header("Location:" .trim(CURRENT_DOMAIN,'/').'/'.trim($url ,'/') );
         exit;
    }
}
