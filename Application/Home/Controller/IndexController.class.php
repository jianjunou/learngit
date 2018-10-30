<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        
        $this->display();

    }
    /**
     * 电影列表接口
     * @return [type] [description]
     */
    public function movies()
    {
    	$movieModel = D("Movie");
        // 可以自行做翻页操作
    	$movieData = $movieModel->field('id, title, shortTitle, imgUrl, loadUrl')->limit(20)->select();

    	echo json_encode($movieData);exit();
    }

    public function movie()
    {
    	$movieId = I('get.id');
		$movieModel = D("Movie"); 
    	$info = $movieModel->field('id, title, imgUrl,shortTitle, loadUrl, secret')->find($movieId);
		echo json_encode($info);exit();

    }

    public function start()
    {
    	$movieModel = D("Movie");
    	$number = 7;
    	$movieData = $movieModel->field('id, title, shortTitle, imgUrl, loadUrl, start')->order('start desc')->limit($number)->select();
    	echo json_encode($movieData);exit();

    }
    /**
     * 电影详情的接口
     * @return [type] [description]
     */
    public function detail()
    {
    	$movieId = I('get.id');
		$movieModel = D("Movie");
    	$info = $movieModel->find($movieId);
        
        echo json_encode($info);exit();

    }

    /**
     * 搜索接口
     * ?kw=
     * 格式：
     * http://api.movie.com/index.php/Home/Index/search?kw=%E7%8A%AF%E7%BD%AA
     * @return [type] [description]
     */
    public function search()
    {
    	$kw = I('get.kw');
		if(!$kw){
			$this->error('请输入关键字');
		}    	
    	$where['title']=array('like','%' . $kw . '%');
    	$movieModel = D("Movie");

    	$movieData = $movieModel->field('id, title, shortTitle, imgUrl, loadUrl, start')->where($where)->select();

        echo json_encode($movieData);exit();
    	// $this->assign('movieData', $movieData);
    	// $this->display();
    }
}