<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event; // 追加
use Cake\Log\Log;

/**
 * VideosController Controller
 *
 *
 * @method \App\Model\Entity\VideosController[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VideosController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('MakeHtml');
    }


    public function isAuthorized($user)
    {
    	return true;

    }

    public function beforeFilter(Event $event)
  	{
  		parent::beforeFilter($event);
  		$this->Security->setConfig('unlockedActions', ['getContent']);
  		$this->Auth->allow(['index','getContent']);

  	}

    public function getContent(){
  		$this->autoRender = FALSE;
  		if($this->request->is('ajax')) {
  			$video = $this->Videos->get($this->request->data['request'], [
  			    'contain' => []
  			]);
  			$video->content = htmlspecialchars_decode($video->content,ENT_QUOTES|ENT_HTML5);
  			$resultJ = json_encode($video);
  			$this->response->type('json');
  			$this->response->body($resultJ);
  			return $this->response;
  		}else{
  			$this->cakeError('error404');
      }
  	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
         $videos = $this->paginate($this->Videos);
         $this->set(compact('videos'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
      $video = $this->Videos->newEntity();
      if ($this->request->is('post')) {
        $imageFile =$this->request->data['thumbnail'];
        $videoFile =$this->request->data['video'];
        $video->title = $this->request->data['title'];
        $video->thumbnail = $imageFile['name'];
        $video->content = $videoFile['name'];
        $video->content = $this->MakeHtml->makeHtmlForVideos($video);
        $video->contName = 'videos';
      if ($this->Videos->save($video)) {
        $this->Flash->success(__('The video has been saved.'));
        move_uploaded_file($imageFile['tmp_name'],'../webroot/img/videos/' . $imageFile['name']);
        move_uploaded_file($videoFile['tmp_name'],'../webroot/mv/videos/' . $videoFile['name']);
        return $this->redirect('/videos');
      }
        $this->Flash->error(__('The video could not be saved. Please, try again.'));
      }
    }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Videos Controller id.
    //  * @return \Cake\Http\Response|void
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $videosController = $this->VideosController->get($id, [
    //         'contain' => []
    //     ]);
    //
    //     $this->set('videosController', $videosController);
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Videos Controller id.
    //  * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Network\Exception\NotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $videosController = $this->VideosController->get($id, [
    //         'contain' => []
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $videosController = $this->VideosController->patchEntity($videosController, $this->request->getData());
    //         if ($this->VideosController->save($videosController)) {
    //             $this->Flash->success(__('The videos controller has been saved.'));
    //
    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The videos controller could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('videosController'));
    // }
    //
    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Videos Controller id.
    //  * @return \Cake\Http\Response|null Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $videosController = $this->VideosController->get($id);
    //     if ($this->VideosController->delete($videosController)) {
    //         $this->Flash->success(__('The videos controller has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The videos controller could not be deleted. Please, try again.'));
    //     }
    //
    //     return $this->redirect(['action' => 'index']);
    // }
}
